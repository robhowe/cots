## CoTs
====

A Symfony2 project created by Rob Howe <rob@robhowe.com> in response to a Code Challenge.

## Requirements:
Using Symfony2, create a simple web app. The goal is to create a rudimentary data pipeline with execution triggers.

PipelineBundle: We want to track "counts" of "things." For example, I may GET/POST to http://your-app/tracker/bananas/3/up. This would increment the "banana counter" by "3" in the "up" direction. These "things" can be created dynamically simply by attempting to access them. For instance, if "banana" didn't exist, it would be created and tracked starting at 0.

TriggerBundle: Depending on the type of tracker, we may want to do certain things at certain counts. For instance, if we were using the tracker to track inventory, we may want to alert when the "banana" tracker reaches 0. Or if we're tracking "messages" we may want to alert at every power of 10. However, we don't want to implement these in the same place as the pipeline itself. We want to be able to launch new triggers without having to modify the code of the Pipeline itself.

Useful references: [Event Dispatcher](http://symfony.com/doc/current/components/event_dispatcher/introduction.html), [Doctrine ORM](http://symfony.com/doc/current/book/doctrine.html), [Swift Mailer](http://symfony.com/doc/current/cookbook/email/email.html)

So a simple flow of the app would be:

    POST/GET /tracker/bananas/3/up
    Create the "bananas" tracker initialized to 0 + 3
    POST/GET /tracker/bananas/3/down
    Set banana tracker to <current> - 3
    Send an email that "bananas" reached 0

====

## Installation:

Although the two bundles included are loosely coupled and able to be deployed separately, for the sake of brevity (and ease of stand-alone installation) they are packaged together here under one project.

This is a simple Symfony2 project.
To get started, update the usual files with your env's settings:
  app/config/config.yml
  app/config/config_dev.yml
  app/config/parameters.yml

To create the database needed, run commands:
  php bin/console doctrine:database:drop --force
  php bin/console doctrine:database:create
  php bin/console doctrine:schema:update --force
If needed, start a Symfony webserver:
  php bin/console server:run

## License

See the included LICENSE.txt file.
All information contained within this project is, and remains the property of Rob Howe.
