| URL | Name | Description de la page | Méthode HTTP | Controller | Méthode | commentaire |
|--|--|--|--|--|--|--|
| `/` | question_list | Liste des questions | GET | QuestionController | list | Page d'accueil avec les questions récentes |
| `/question/[id]` | question_show | La question avec ses réponses | GET | QuestionController | show | question et ses réponses selon son id |
| `/question/tag/{name}` | questions_tag | liste des questions selon un tag | GET | QuestionController | listByTag ||
|`/user/question/ask`|question_ask|Formulaire création de question|POST|QuestionController|form|Même méthode pour création et edit de la question|
|`/user/question/{id}/answer`|answer_submit|Répondre à une question|POST|AnswerController|answer||
|`/signup`|sign_up|formulaire d'inscription|GET/POST|UserController|signUp||
`/login`|log_in|Formulaire de connexion|GET/POST|UserController|login||
`/profile`|profile_show|Informations du compte et liste questions et réponses de l'utilisateur|GET|UserController|show||
`/profile/edit`|profile_edit|Modifiction des informations perso du compte utilisateur|POST|UserController|edit||
|`/admin/question/[id]/SwitchStatus`|question_switchStatus|Bloquer /débloquer une question|POST|AdminController|switchStatus||
|`/admin/question/[id]/answer/[id]/status`|answer_switchStatus|Bloquer/débloquer une réponse à une question|POST|AdminController|switchStatus||
|`/admin/users`|user_role|Permet à un admin de changer les droits d'un utilisateur|POST|AdminController|role||
|`/admin/tags/create`|tag_create|Créer un tag|POST|TagController|form|Méthode commune creation update|
|`/admin/tags/edit`|tag_edit|Modifier un tag|POST|TagController|form||
|`/admin/tags/delete`|tag_delete|Supprimer un tag|POST|TagController|delete||