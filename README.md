# OpenCart Plugin [![.NET](https://github.com/VodaPay-Gateway/vodapay-gateway-plugin-opencart/actions/workflows/release.yml/badge.svg?branch=main)](https://github.com/VodaPay-Gateway/vodapay-gateway-plugin-opencart/actions/workflows/release.yml)

## OpenCart
[OpenCart](https://www.opencart.com/) is a free open-source e-commerce platform for online merchants. OpenCart provides a professional and reliable foundation from which to build a successful online store. 

---

## Table of contents

- [OpenCart Plugin ](#opencart-plugin-)
  - [OpenCart](#opencart)
  - [Table of contents](#table-of-contents)
  - [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
  - [Usage](#usage)
    - [Install plugin](#install-plugin)
    - [Testing](#testing)
  - [Contributing](#contributing)
  - [Commit Messages](#commit-messages)
  - [Built With](#built-with)
  - [Tags](#tags)


---
## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See [Commit Messages](#commit-messages) for notes on how to release the project.

---

## Prerequisites
This project requires [PHP 7.4](https://windows.php.net/download#php-7.4) and [git](https://git-scm.com/downloads) if not already installed. This project also requires an [OpenCart 3.0.3.8](https://github.com/opencart/opencart/releases/download/3.0.3.8/opencart-3.0.3.8.zip) platform to install the plugin on.                                            
To make sure you have it available on your machine,
try running the following command.

PHP 7.4 version check
```sh
$ php -v
```
git version check
```sh
$ git --version
```
---

## Installation

**BEFORE YOU INSTALL:** please read the [prerequisites](#prerequisites)

Start with cloning this repo on your local machine to make the necessary changes:

```sh
$ git clone https://github.com/VodaPay-Gateway/vodapay-gateway-plugin-opencart.git
$ cd PROJECT
```

---
## Usage

### Install plugin

1. Head to the test site backend.
2. Then the **Extensions** section.
3. Followed by the **Installer** section where a `vodapay-gateway.ocmod.zip` file should be uploaded.
4. Then head to **Extensions**** and then filter by **Payments**.
5. Head to **Vodapay Gateway** to install and configure the plugin.

### Testing

1. Head to the test site front end.
2. Select a product to add to the cart.
3. Head to checkout and follow the steps.
4. When at Payment Method select the **Vodapay Gateway** option and continue. 
5. Press the **continue** button and after completing the payment journey review the response.

## Contributing

Create a branch based on the change being made to the repository:
- Features: feature/new-feature
- Bug Fixes: fix/fix-problem


Steps to follow:
1.  Create your feature branch: `git checkout -b feature/my-new-feature`
2.  Add your changes: `git add .`
3.  Commit your changes: `git commit -m 'Why I did what I did'`
4.  Push to the branch: `git push origin feature/my-new-feature`
5.  Submit a pull request.
---


## Commit Messages
When committing changes, specific messages are required to create a release.

* `feat(scope): Why I did what I did` is for committing a feature added to the plugin.
* `fix(scope): Why I did what I did` is for committing a fix to the plugin.

The scope is an optional addition to specify what the change focused on.

---
## Built With

* PHP
* [MVC-L design pattern](https://docs.opencart.com/developer/module/)

## Tags

 * For the tags available, see the [tags on this repository](https://github.com/VodaPay-Gateway/vodapay-gateway-plugin-opencart/tags).