#Todolist
Mini-projet création d'une API from scratch en PHP, réalisé dans le cadre d'un test technique pour Médialis

#Subject
* Création d’une API from scratch
* L’api à réaliser servira à créer des TODOLIST.
* On doit donc pouvoir ajouter/modifier/supprimer des listes et les items des listes.
* L’api n’intègrera que le GET / POST / DELETE, on se passera du PUT.
* Il doit y avoir un petit système de credentials (un token statique est accepté)
* Le développement doit respecter l’architecture MVC, et la partie back doit être totalement
* réalisée en objet.
* La version de PHP est libre mais a minima du 5.6.
* Niveau base de données le choix est libre.
* Et pour le front, IHM/techno libre.

#Routes
* 'GET' /api/authToken
* 'GET' /api/taskList
* 'GET' /api/taskList/{idList}
* 'GET' /api/taskList/{taskListId}/tasks
* 'POST' /api/user
* 'POST' /api/taskList
* 'POST' /api/taskList/{taskListId}
* 'POST' /api/taskList/{taskListId}/task
* 'POST' /api/task/{taskId}
* 'DELETE' /api/taskList/{taskListId}
* 'DELETE' /api/task/{taskId}

#Exemple of request



| Description          | Request path                 | Parameter                                                            |   Expected return                                                 | 
| :------------------- | ---------------------------- |: ------------------------------------------------------------------- | :---------------------------------------------------------------- |
| Create user          | 'POST' /api/user             | Body {username: "root", password: "Root123*"}                        | 201 "auth_token": "mO2F0rED4dVF8u5jvRvoekH4C/oFLgzsOpjXeiEBVq4="  |
| Login user           | 'GET' /api/authToken         | Header {username: "root", password: "Root123*"}                      | 200 "auth_token": "mO2F0rED4dVF8u5jvRvoekH4C/oFLgzsOpjXeiEBVq4="  |
| Create a taskList    | 'POST' /api/taskList         | Header {auth_token": "mO2F0rED4dVF8u5jvRvoekH4C/oFLgzsOpjXeiEBVq4="} Body {"title: "My first work list" | 201 "message": "New list created" |
| Get all taskList     | 'GET' /api/taskList          | Header {auth_token": "mO2F0rED4dVF8u5jvRvoekH4C/oFLgzsOpjXeiEBVq4="} | 200 {"0":{"id_user":26,"id_tasklist":28,"title":"My Home list"}}} |
| Get one taskList     | 'GET' /api/taskList/{taskListId}  | Header {auth_token": "mO2F0rED4dVF8u5jvRvoekH4C/oFLgzsOpjXeiEBVq4="} | 200 {"0":{"id_user":26,"id_tasklist":28,"title":"My Home list"}}} |
| Update a taskList    | 'POST' /api/taskList/{taskListId} | Header {auth_token": "mO2F0rED4dVF8u5jvRvoekH4C/oFLgzsOpjXeiEBVq4=" Body {"title": "new title"} | 200 {"message": "taskList n°28 has been updated"} |
| Update a taskList    | 'POST' /api/taskList/{taskListId} | Header {auth_token": "mO2F0rED4dVF8u5jvRvoekH4C/oFLgzsOpjXeiEBVq4=" Body {"title": "new title"} | 200 {"message": "taskList n°28 has been updated"} |
                                    


* 'GET' /api/taskList/{taskListId}/tasks

* 'POST' /api/taskList
* 'POST' /api/taskList/{taskListId}
* 'POST' /api/taskList/{taskListId}/task
* 'POST' /api/task/{taskId}
* 'DELETE' /api/taskList/{taskListId}
* 'DELETE' /api/task/{taskId}