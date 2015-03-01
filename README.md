Cogs runs with the following flow:
* index.php
* Load configuration file cogs.config.php
* Toggle debug mode depending on value in config file
* Include core framework files and dependencies
* Create connection to database
* Include models from plugins
* Include all other main models that may depend on plugins
* Include controllers from plugins
* Include all other main controllers that may depend on plugins
* Include all other plugin files
* Define master template
* Traverse URI for correct controller to call
* Run controller if one is found
* Close database connection

Cogs Controller Details:

Cogs uses traversal of URI to determine which controller to call in order to generate pages. It begins at the end of the URI, looks at each part of the path until it gets to the root. Cogs uses the Camel_Case convention for all controller classes. When looking for a controller, it is case-insensitive based on the string in the URI.

For example:
URI: /food/fruit/apple
Controllers loaded: Food ; Fruit

From traversing the URI, it will load the Fruit controller because it found it first. Upon loading the controller, it calls the public method index() to determine what page it generates and commands are run.

If the frontend plugin is used to extend the main frontend controllers, you can call parent::index() to run a predetermined set of code for each page (such as getting the contact information for the footer).

Cogs::view(‘View_File_Name_Without_Extension’) will load the desired view.

Cogs::render($this) will render and output the page. It passes all of the data from the instance variable $this. It is recommended that all data to be passed to $this for access within the view.

--

CRUD plugin can do unlimited bidirectional relationships between models
