# Contributing to AutoMarkDoc

Thank you for your interest in contributing to AutoMarkDoc! Contributions are welcome and appreciated. This guide will help you get started.

## 📌 How to Contribute

### 1. Fork the Repository
- Navigate to the [AutoMarkDoc GitHub repository](https://github.com/partITech/AutoMarkDoc).
- Click on the **Fork** button to create your own copy of the repository.
- Clone your fork to your local machine:

  ```sh
  git clone https://github.com/YOUR_GITHUB_USERNAME/AutoMarkDoc.git
  cd AutoMarkDoc
  ```

- Add the upstream repository to stay up to date with changes:

  ```sh
  git remote add upstream https://github.com/partITech/AutoMarkDoc.git
  git fetch upstream
  ```

### 2. Create a New Branch
Before making any changes, create a new branch based on the `main` branch:

```sh
git checkout -b feature-branch-name
```

### 3. Install Dependencies
Ensure you have all required dependencies installed:

```sh
docker compose build
docker compose up -d
docker compose exec php composer install
```

### 4. Make Your Changes
Modify the code or documentation as needed. Ensure your code follows best practices and maintains consistency with the project's style.

### 5. Commit Your Changes
Write clear, concise commit messages:

```sh
git add .
git commit -m "[Feature] Describe your changes concisely"
```

### 6. Push to Your Fork

```sh
git push origin feature-branch-name
```

### 7. Submit a Pull Request (PR)
- Go to the original repository on GitHub.
- Click on **Pull Requests** > **New Pull Request**.
- Select your fork and branch, then submit the PR with a detailed description of your changes.

## 🔍 Code Guidelines
- Follow **PSR-12 coding standards** for PHP.
- Ensure proper **naming conventions** for variables and functions.
- Avoid unnecessary complexity; keep the codebase **clean and maintainable**.

## 🏷 Issue Tracking
If you find a bug or want to suggest an enhancement, please open an **issue** on GitHub. Clearly describe the problem, expected behavior, and steps to reproduce.

## 🤝 Community Guidelines
- Be respectful and inclusive.
- Communicate clearly and be constructive in discussions.
- Help others by reviewing and commenting on open PRs.

## 🚀 Thank You!
Your contributions help make AutoMarkDoc better. We appreciate your effort and support!

If you have any questions, feel free to ask in the **GitHub Discussions** or open an issue.
