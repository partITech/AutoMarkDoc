# Quick Start

You can use the same application to manage multiple documentations.
Here’s how to set it up:

```shell
## checkout project
git submodule add https://github.com/partITech/sonata-extra  documentations/sonata-extra

## update docs later
git submodule update --remote
```

The documentation for the sonata-extra repository is located in the following path: [/docs](https://github.com/partITech/sonata-extra/tree/main/docs)

## Configuration

In your environment variables or the dotenv file of your project:


**DOCUMENTATION_PROJECTS** must contain a JSON structure listing each project along with its corresponding path.
The path is relative to the document root of the application.

> [!NOTE]
> You can add as many projects as needed, as long as each one has a unique segment/host.


```.dotenv
DOCUMENTATION_PROJECTS='{
    "automarkdoc": {
        "path": "documentations/AutoMarkDoc",
        "segment": "automarkdoc",
        "host": "localhost",
        "name": "AutoMarkDoc"
    },
    "sonata-extra": {
        "path": "documentations/sonata-extra/docs",
        "segment": null,
        "host": "sonata-extra.localhost",
        "name": "Sonata Extra"
    }
}'
```


