[![GitHub license](https://img.shields.io/github/license/alphp/Crypto-Key-Tools)](https://github.com/alphp/Crypto-Key-Tools/blob/master/LICENSE)
[![GitHub tag (latest SemVer)](https://img.shields.io/github/v/tag/alphp/Crypto-Key-Tools)](https://github.com/alphp/Crypto-Key-Tools/tags)
[![Packagist](https://img.shields.io/packagist/v/alphp/crypto-key-tools)](https://packagist.org/packages/alphp/crypto-key-tools)
[![Packagist Downloads](https://img.shields.io/packagist/dt/alphp/crypto-key-tools)](https://packagist.org/packages/alphp/crypto-key-tools/stats)
[![GitHub issues](https://img.shields.io/github/issues/alphp/Crypto-Key-Tools)](https://github.com/alphp/Crypto-Key-Tools/issues)
[![GitHub forks](https://img.shields.io/github/forks/alphp/Crypto-Key-Tools)](https://github.com/alphp/Crypto-Key-Tools/network)
[![GitHub stars](https://img.shields.io/github/stars/alphp/Crypto-Key-Tools)](https://github.com/alphp/Crypto-Key-Tools/stargazers)

# Crypto Key Tools

A self-hosted collection of tools for generating, converting and inspecting cryptographic keys and related formats.

> **Generate, convert and inspect cryptographic keys without sending sensitive data to third-party services.**

## Why?

Many online tools are extremely useful when you need to generate a key pair, convert between formats or inspect certificates. However, using a third-party website means trusting that sensitive material is handled correctly.

**Crypto Key Tools** is designed for users and organizations that prefer to keep cryptographic material entirely within their own infrastructure.

## Features

* Generate cryptographic key pairs.
* Convert keys between multiple formats.
* Inspect keys, certificates and related cryptographic data.
* Browser-based interface.
* Agnostic Routing: Consistent behavior across LAMP (Apache), IIS, and PHP's built-in server.
* Easy deployment with Composer.

## Installation

### Recommended

Install the latest version directly with Composer:

```bash
composer create-project alphp/crypto-key-tools
```

The project will be installed in a new `crypto-key-tools` directory, ready to be served by your web server.

### From source

```bash
git clone https://github.com/alphp/crypto-key-tools.git
cd crypto-key-tools
composer install
```

## Local Development

For quick testing or development, you can use PHP's built-in web server. Since the project follows a Front Controller pattern where the entry point is located in the `wwwroot` directory, you must point the document root to that folder:

```bash
# From the project root directory
php -S localhost:8000 -t wwwroot
```

## Why this works:

* **Agnostic Routing**: The system automatically calculates the `REQUEST_BASE`, ensuring that all internal links and the MiniRouter work correctly without manual configuration.
* **Security by Design**: By serving only the `wwwroot` folder, sensitive files like `bootstrap.php`, `constants.php`, and the `templates` directory remain outside the web-accessible path.

## Usage

1. Deploy the project to your web server (or run it locally).
2. Open the application in your browser.
3. Select the desired cryptographic operation.
4. Generate, inspect or convert your keys.

## Security

This project is intended to be run on systems that you control.

* The system protects against direct access to sensitive files (`.env`, `.git`, `.config`) by routing them to the Front Controller for a controlled 404 state.
* Use HTTPS whenever possible and restrict access to trusted users.

## License

This project is licensed under the **MIT License**. See the `LICENSE` file for details.
