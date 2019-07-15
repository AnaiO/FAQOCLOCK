| URL | Name | Description de la page | Méthode HTTP | Controller | Méthode | commentaire |
|--|--|--|--|--|--|--|
| `/` | question_list | Liste des questions | GET | QuestionController | list | Page d'accueil avec les questions récentes |
| `/question/[id]` | question_show | La question avec ses réponses | GET | QuestionController | show | question et ses réponses selon son id |
| `/question/tag/{name}` | questions_tag | liste des questions selon un tag | GET | QuestionController | listByTag ||
|`/user/question/ask`|question_ask|Formulaire création de question|POST|QuestionController|form|Même méthode pour création et edit de la question|
|`/user/question/{id}/answer`|answer_submit|Répondre à une question|POST|AnswerController|answer||
|`/user/question/answer/{id}/validate`|answer_validate|Valider la bonne réponse à une question|POST|AnswerController|validate||
|`/signup`|sign_up|formulaire d'inscription|GET/POST|UserController|signUp||
`/login`|log_in|Formulaire de connexion|GET/POST|UserController|login||
`user/profile`|profile_show|Informations du compte et liste questions et réponses de l'utilisateur|GET|UserController|show||
`user/profile/edit`|profile_edit|Modifiction des informations perso du compte utilisateur|POST|UserController|edit||
|`/Backend/question/[id]/toggle`|backend_question_toggle|Bloquer /débloquer une question|POST|Backend\QuestionController|toggle||
|`/Backend/question/answer/[id]/toggle`|backend_answer_toggle|Bloquer/débloquer une réponse à une question|POST|Backend\AnswerController|toggle||
|`/Backend/users`|user_role|Permet à un admin de changer les droits d'un utilisateur|POST|AdminController|role||
|`/Backend/tag/list`|tags_list|liste des tags|GET|Backend\TagController|list||
|`/Backend/tag/create`|tag_create|Créer un tag|POST|TagController|form|Méthode commune creation update|
|`/Backend/tag/edit`|tag_edit|Modifier un tag|POST|TagController|form||
|`/admin/tag/delete`|tag_delete|Supprimer un tag|POST|TagController|delete||