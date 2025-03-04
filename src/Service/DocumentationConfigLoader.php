<?php

namespace App\Service;

use Exception;
use Partitech\SonataExtra\Repository\ContactRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Config\FileLocator;

class DocumentationConfigLoader
{
    private array $config = [];
    private string $host;
    private string $path;
    private string $projectPath;
    private string $projectName;
    private string $segment='/';
    private string $scheme;
    private ?string $hostPart = null;

    public function __construct(
        #[Autowire('%kernel.project_dir%')] private readonly string $projectDir,
        private readonly array                                      $projects,
        private readonly Filesystem                                 $filesystem
    )
    {}

    public function redirect(string $file, string $title): string|bool
    {

        if(is_null($this->projects[$this->projectName]['host']) || empty($this->projects[$this->projectName]['host']) || !isset($this->projects[$this->projectName]['host'])){
            $host = $this->host;
        }else{
            $host = trim($this->projects[$this->projectName]['host'], '/');
        }

        if($host != $this->host || $this->path != trim($this->projects[$this->projectName]['segment'], '/')){
            return $this->createUrl($this->projectName, $file, $title);
        }

        return false;
    }

    public function createUrl(string $project, ?string $file=null, ?string $title=null):string
    {
        $host = trim($this->projects[$project]['host'], '/');
        if(empty($host)){
            $host = $this->host;
        }
        $segment = trim($this->projects[$project]['segment'], '/');

        $queryParams = null;
        if(!is_null($file)){
            $queryParams = "&file=" . urlencode($file); ;
        }
        if(!is_null($title)){
            $queryParams .= "&title=" . urlencode($title);
        }

        if(!is_null($queryParams)){
            $queryParams = "?"  . $queryParams;
        }

        return $this->scheme .  '://' . $host . '/' . $segment . $queryParams;
    }

    public function getSitesList(): array
    {
        $list = [];
        $currentItem = null;

        foreach ($this->projects as $project => $config) {
            $item = [
                'url'     => $this->createUrl($project),
                'name'    => $config['name'],
                'current' => ($project === $this->projectName),
            ];

            if ($item['current']) {
                $currentItem = $item;
            } else {
                $list[] = $item;
            }
        }

        if ($currentItem !== null) {
            $list[] = $currentItem;
        }

        return $list;
    }


    /**
     * @throws Exception
     */
    public function setRequest(Request $request):self
    {
        $this->host = trim($request->getHost(), '/');
        $this->path = trim($request->getPathInfo(), '/');
        $this->scheme = $request->getScheme();

        $projectName = $this->getProjectFromRequest($this->host, $this->path);
        if(is_null($projectName)){
            $projectName = array_key_first($this->projects);
        }
        $this->projectName = $projectName;
        $this->projectPath = $this->getProjectPath();

        try {
            $file = $this->getFilePath( 'config.yaml');
        }catch (\Throwable $e){
            throw new Exception('Unable to locate config.yaml file for the project ' . $this->projectName);
        }

        $this->config = Yaml::parseFile($file);
        return $this;
    }

    public function setProject(string $projectName): self
    {
        $this->projectName = $projectName;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function getFilePath(string $file): string
    {
        $basePath = $this->projectDir . DIRECTORY_SEPARATOR . $this->getProjectPath();
        if (!$this->filesystem->exists($basePath)) {
            throw new Exception('Unable to locate config.yaml file for the project ' . $this->projectName);
        }

        $fileLocator = new FileLocator([$basePath]);

        $fileLocator = new FileLocator([$basePath]);
        try {
            $file = $fileLocator->locate($file, null, true);
        }catch (\Throwable $e){
            throw new Exception('Unable to locate config.yaml file for the project ' . $this->projectName);
        }

        return $file;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->config[$key] ?? $default;
    }

    public function getAll(): array
    {
        return $this->config;
    }

    public function getProjectPath(): ?string
    {
        return $this->projects[$this->projectName]['path'] ?? null;
    }

    public function getProjectFromRequest(string $host, string $path): ?string
    {
        $segments = array_filter(explode('/', trim($path, '/')));

        // Case 1 : domaine/projet1
        if (count($segments) >= 1 && isset($this->projects[$segments[0]])) {
            $this->segment = $segments[0];
            return $segments[0];
        }

        // Case 2 : projet1.domaine
        $hostParts = explode('.', $host);

        if (count($hostParts) >= 2 && isset($this->projects[$hostParts[0]])) {
            $this->hostPart = $hostParts[0];
            return $hostParts[0];
        }

        return null;
    }

    public function getProjectName(): string
    {
        return $this->projectName;
    }

    public function getSegment(): string
    {
        return $this->segment;
    }

}
