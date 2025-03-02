# Quick start

> [!NOTE]
> Note that you will need to install project before going into the main configuration

1. **Create a Documentation Folder**  
   !!!bash
   mkdir -p documentations/docs
   !!!

2. **Add Markdown Files**  
   Place your existing `.md` files or create new ones inside `documentations/docs/`.

3. **Use Default Configuration**  
   If you haven’t already, copy or create a minimal `config.yaml` at the root of your project:
   !!!yaml
   projectName: "My Project Docs"
   !!!
   (See [Installation](installation.md) for detailed config options.)

4. **Serve the Documentation Locally**  
   If you’re using Symfony:
   !!!bash
   symfony server:start
   !!!
   or with PHP’s built-in server:
   !!!bash
   php -S localhost:8000 -t public/
   !!!
   Then visit `http://localhost:8000` in your browser to see the docs.

5. **Explore Further**
    - For a detailed installation guide, check [Installation](installation.md).
    - To customize and style your docs, see [Graphical Examples](markdown_examples.md).
    - Enjoy writing in Markdown without worrying about manual formatting or site design!
