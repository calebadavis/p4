## Live URL
<http://p4.prowlers.com>

## Description
* An image gallery showcasing LilySprite Photography.
* Images are organized by gallery (and also by the identity of the currently logged-in user): Public galleries (guest-accessible) are: 'Portraits', 'Creative Photography', 'Fantasy Edits', and 'Modeling'. 
* User authentication: The landing page permits login/logout/signup. Once a user is authenticated, he/she gets access to the 'Restricted' and 'Mature' galleries.
* Per-user image filtering: The 'Restricted' gallery contains images that display only to a set of specific users.
* Administrative UIs: If the logged-in user has 'Administrator' privs, he/she gets access to UI which permits publishing of new images, modification of existing images, and deletion of images.
* Data-driven content: The display of galleries and images is entirely driven by Database data. The views 'app/views/index.blade.php' and 'app/views/gallery.blade.php' demonstrate the generation of UI based almost entirely on data from the 'galleries' and 'photos' tables.
* Demonstrates Laravel eloquent ORM interactions, DB migrations, routes, controllers, views, and templates. Most routes and UI leverage the three eloquent object types (User, Gallery, and Photo). Additionally, there are sensible relationships at the schema level between these objects - Photos belong to Galleries in a one-to-many relationship, and Photos are visible to Users through a many-to-many relationship. A join (or pivot) table 'photo_user' enables this last relationship.
* Because this project is a substantial re-write of a previous project (my final project for CSCI-E12, Fundamentals of Website Development), and is meant to replace the current production static site (lilysprite.com), it has a data conversion capability. This conversion is a one-time import of the data from the old hardcoded galleries (each one has a .csv file) to the new eloquent DB models. To see how this works, take a look at the route '/migrate' and the controller 'app/controllers/MigrateController.php'. You can see the old site's main 'index' page 'public/old_index.php' to get a sense of the way the infrastructure is entirely different, even though the display is very similar.

## Demo URL
<http://www.screencast.com/t/z085REhxN3g>

## Outside code/resources
* https://github.com/susanBuck/foobooks.git: Much of the authentication plumbing/UI draws heavily from the lecture example 'foobooks' laravel app. Also error handling/display (with flash_messages and dynamic generation of error message <div> sections) is based off the 'foobooks' example.
* http://fancyapps.com/fancybox: The display of thumbnails/images in each gallery relies on the 'FancyBox 2.0' jquery widget.
* https://github.com/lou/multi-select: The UI which allows selection of multiple users (associating users to a photo) displays an option-transfer dialog from Louis Cuny's 'multi-select' jquery plugin. This UI shows up in the administrative pages to publish a new photo, and to modify an existing photo.
* https://github.com/rvera/image-picker: The administrative UI allowing a user to select an existing photo (for delete or modify) comes from Rodrigo Vera's 'Image Picker' jquery widget.




