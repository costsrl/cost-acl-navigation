CostAclNavigation
=======

**What is CostAclNavigation?**

CsnNavigation is a Module for Navigation based on Laminas Framework 2 with Acl

**What exactly does CostNavigation?**


Installation
============

Requiremnts "CostAuthorization"


Go to your application configuration in ```./config/application.config.php```and add 'CostAclNavigation'.
An example application configuration could look like the following:

```
'modules' => array(
    'Application',
    'CostAuthorization',
    'CostNavigation'
)
```

Navigation configuration
=============
Create novigo folder under vendor directory 
Copy or Clone Module under novigo directory
Copy `./vendor/cost/cost-acl-navigation/config/navigation.global.php.dist` to
   `./config/autoload/navigation.global.php` and edit.
   
   
open composer.json and add under auotload key

"autoload" : {
    "psr-4" : {
      "CostAclNavigation" : "vendor/cost/cost-acl-navigation/src",
    }
```
or 
 "repositories": [
        {
            "type": "vcs",
            "url": "http://git.cost.it/cost/cost-acl-navigation.git"
        }
    ]

Show navigation
=============
Add this somewhere in your layout `./module/Application/view/layout/layout.phtml` :
````
<ul class="nav navbar-nav">
<?php
      $navHelper = $this->navigation('navigation_default');
      $containers = $navHelper->getContainer();
      $acl = $navHelper->getAcl();
      $role = $navHelper->getRole();
      foreach($containers->getPages() as $page) {    
              if(! $navHelper->accept($page))
                  continue;
                  $class = "";
                  if ($page->isActive() && $navHelper->accept($page)) {
                                    $class = "active";
                  }
    
                  if(count($page)) {
                       // if there are subpages we render the menu a bit different
                       $label  = $page->getLabel();
                       $label  = $this->translate($label); // translated label
                       $label  = $this->escapehtml($label); // sanitized label
                       printf('<li class="dropdown%s">'."\n",($class?' '.$class:''));
                       printf('<a href="%s" class="dropdown-toggle" data-toggle="dropdown">%s<b class="caret"></b></a>'."\n",
                                                 $page->getHref(),
                                                 $label);
                      echo '<ul class="dropdown-menu" role="menu">'."\n";
                      foreach($page as $subPage) {
                                   if(!$navHelper->accept($subPage)) {
                                           	continue;
                                   }
                                   printf("<li>%s</li>\n",$navHelper->htmlify($subPage));
                                                            }
                               echo "</ul></li>\n";
                 }
                  else {
                   printf("<li class=\"%s\">%s</li>\n",$class,$navHelper->htmlify($page));
             }
       }
        ?>						
</ul>
````




doctrine generate entity

    1) ./vendor/doctrine/doctrine-module/bin/doctrine-module orm:convert-mapping --namespace="CostAclNavigation\\Model\\Entity\\" --filter='Menus' --force  --from-database annotation ./vendor/cost/cost-acl-navigation/src/
   

    2) ./vendor/doctrine/doctrine-module/bin/doctrine-module orm:validate-schema


    3) 	./vendor/doctrine/doctrine-module/bin/doctrine-module orm:generate-entities --generate-annotations=true --generate-methods=true ./vendor/novigo/Cost-acl-navigation/src 

    doctrine create update databse from  entity
    4) ./vendor/doctrine/doctrine-module/bin/doctrine-module orm:schema-tool:update  --dump-sql

    5) ./vendor/doctrine/doctrine-module/bin/doctrine-module schema-tool:update --force


```