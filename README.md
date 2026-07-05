[![GitHub license](https://img.shields.io/github/license/alphp/Crypto-Key-Tools)](https://github.com/alphp/Crypto-Key-Tools/blob/master/LICENSE)
[![GitHub tag (latest SemVer)](https://img.shields.io/github/v/tag/alphp/Crypto-Key-Tools)](https://github.com/alphp/Crypto-Key-Tools/tags)
[![Packagist](https://img.shields.io/packagist/v/alphp/crypto-key-tools)](https://packagist.org/packages/alphp/crypto-key-tools)
[![Packagist Downloads](https://img.shields.io/packagist/dt/alphp/crypto-key-tools)](https://packagist.org/packages/alphp/crypto-key-tools/stats)
[![GitHub issues](https://img.shields.io/github/issues/alphp/Crypto-Key-Tools)](https://github.com/alphp/Crypto-Key-Tools/issues)
[![GitHub forks](https://img.shields.io/github/forks/alphp/Crypto-Key-Tools)](https://github.com/alphp/Crypto-Key-Tools/network)
[![GitHub stars](https://img.shields.io/github/stars/alphp/Crypto-Key-Tools)](https://github.com/alphp/Crypto-Key-Tools/stargazers)

# Crypto Key Tools

A self-hosted collection of tools for generating, converting and inspecting cryptographic keys and related formats.

## Why?

Many online tools are extremely useful when you need to generate a key pair, convert between formats or inspect certificates. However, using a third-party website means trusting that sensitive material is handled correctly.

**Crypto Key Tools** is designed for users and organizations that prefer to keep cryptographic material entirely within their own infrastructure.

Deploy it on your workstation, development machine or internal server and process your keys without sending them to external services.

## Features

* Generate cryptographic key pairs.
* Convert keys between multiple formats.
* Inspect keys, certificates and related cryptographic data.
* Browser-based interface.
* Self-hosted.
* Open source.
* Easy deployment.

## Why self-host?

Although many online cryptographic tools perform all operations locally in the browser, self-hosting provides additional benefits:

* You control the application that is being executed.
* No dependency on the availability of external websites.
* Suitable for isolated or air-gapped environments.
* Compatible with corporate security policies.
* No need to expose sensitive material outside your network.

## Installation

Clone the repository:

```bash
git clone https://github.com/<username>/<repository>.git
cd <repository>
composer update -W
```

Serve the project using any web server capable of serving static files (or follow the project-specific deployment instructions).

Examples:

* Apache
* Nginx
* Caddy
* PHP built-in server (if applicable)

## Usage

1. Open the application in your browser.
2. Select the desired cryptographic operation.
3. Generate, inspect or convert your keys.
4. Download or copy the resulting data.

## Security

This project is intended to be run on systems that you control.

For maximum security:

* Use HTTPS whenever possible.
* Restrict access to trusted users.
* Keep your deployment up to date.
* Verify generated results before using them in production.

## Inspiration

This project was inspired by the excellent online utilities available at:

https://8gwifi.org/sshfunctions.jsp
https://emn178.github.io/online-tools/rsa/key-generator/

The goal is **not** to replace those tools, but to provide a self-hosted alternative for environments where privacy, availability or compliance requirements make external services undesirable.

## Contributing

Contributions are welcome.

Feel free to open an issue or submit a pull request if you have ideas for new features, improvements or bug fixes.

## License

This project is released under the terms of the project's license.
