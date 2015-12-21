# Silex Configuration Service Provider
[![Build Status](https://travis-ci.org/kabudu/silex-config-service-provider.svg)](https://travis-ci.org/kabudu/silex-config-service-provider)

The configuration service provider provides a framework for managing application configuration within a Silex application. If you do not know what Silex is, it is a PHP micro-framework created by the makers of Symfony. You can find out more about Silex [here](http://silex.sensiolabs.org/).
It can support an unlimited number of configuration sources and supports configuration cascading based on the order in which you define your configuration sources. It comes shipped with 2 parsers:

* A Yaml file parser (with support for import declarations)
* An environment variable parser