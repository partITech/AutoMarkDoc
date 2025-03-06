# AutoMarkDoc

AutoMarkDoc is an open-source tool that transforms Markdown-based project documentation into a modern, responsive website. Built with Symfony and Bootstrap, it enables effortless documentation generation with minimal setup.

## 🚀 Features
- **Instant Documentation Website**: Converts Markdown files into a sleek, navigable website.
- **Bootstrap-Powered UI**: Responsive and modern design.
- **Simple Setup**: Get started with just a few commands.
- **Customization**: Modify styles and configurations via `config.yaml`.
- **Open Source & Free**: No hidden costs or licensing fees.

## 📦 Installation

### 1. Clone the Repository
```sh
# Create a directory for AutoMarkDoc and navigate into it
mkdir AutoMarkDoc
cd AutoMarkDoc

# Clone the repository from GitHub
git clone https://github.com/partITech/AutoMarkDoc .
```

### 2. Set Up a Local Server (Docker Required)
```sh
# Build the Docker images
docker compose build

# Start the Docker containers in detached mode
docker compose up -d
```

### 3. Install Dependencies
```sh
# Install required PHP dependencies using Composer
docker compose exec php composer install
```

### 4. Configure Environment Variables
A minimal `.env` file is required for proper functionality.

#### Example `.env` Configuration
```dotenv
# Configuration for local development
PHP_IDE_CONFIG="serverName=localhost"
NGINX_PORT=82

# Define the documentation projects as a JSON structure
DOCUMENTATION_PROJECTS='{
    "automarkdoc": {
        "path": "documentations/AutoMarkDoc",
        "segment": "automarkdoc",
        "host": "localhost",
        "name": "AutoMarkDoc"
    }
}'

# Define application environment
# Uncomment these for production
# APP_ENV=prod
# APP_DEBUG=0

# Development settings
APP_ENV=dev
APP_DEBUG=1
```

Or for production: 
```dotenv
DOCUMENTATION_PROJECTS='{
    "automarkdoc": {
    "path": "documentations/AutoMarkDoc",
    "segment": "",
    "host": "automarkdoc.partitech.com",
    "name": "AutoMarkDoc"
    }
}'

APP_ENV=prod
APP_DEBUG=0
```


Refer to the [General Configuration](http://automarkdoc.partitech.com/?file=env.md&title=Getting%20Started) section for more details.

## 🛠 Usage

### 1. Define Your Menu Structure
Create a `menu.md` file to organize your documentation navigation:
```markdown
## Getting Started
- [Introduction](introduction.md)
- [Installation](installation.md)
- [Quick Start](quick_start.md)
```

### 2. Configure `config.yaml`
Customize the project settings:
See the [complete doc section](https://automarkdoc.partitech.com/?file=quick_start.md&title=Getting%20Started) 

```yaml
# Define project metadata
projectName: "AutoMarkDoc"
logoUrl: "/images/logo.svg"
projectSource: "https://github.com/partITech/AutoMarkDoc"

```

### 3. Start the Application
Ensure your local server is running and access the generated documentation website.

## 📖 Documentation
Complete documentation is available at: [AutoMarkDoc Official Website](http://automarkdoc.partitech.com/)

## 🤝 Contributing
We welcome contributions! Please check out our **[CONTRIBUTING.md]** (to be added) for guidelines on how to get started.

## ⚖️ License
AutoMarkDoc is open-source software. A license file will be added soon.

## 💡 Why AutoMarkDoc?
Many open-source projects already use Markdown for documentation. AutoMarkDoc simplifies the process by automatically generating a beautiful, structured website, reducing the need for manual formatting or custom-built solutions.

---

⭐ **If you find this project useful, please consider starring the repository on GitHub!**
