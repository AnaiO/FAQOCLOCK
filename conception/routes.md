| URL | Name | Description de la page | Méthode HTTP | Controller | Méthode | commentaire |
|--|--|--|--|--|--|--|
|`/` | question_list | Liste des questions | GET | QuestionController | list | Page d'accueil avec les questions récentes |
|`/signup`|sign_up|formulaire d'inscription|GET/POST|UserController|signUp||
`/login`|log_in|Formulaire de connexion|GET/POST|UserController|login||
|`/question/[id]` | question_show | La question avec ses réponses | GET | QuestionController | show | question et ses réponses selon son id |
|`/question/tag/{name}` | questions_tag | liste des questions selon un tag | GET | QuestionController | listByTag ||
`/user/profile`|profile_show|Informations du compte et liste questions et réponses de l'utilisateur|GET|UserController|show||
`/user/profile/edit`|profile_edit|Modifiction des informations perso du compte utilisateur|POST|UserController|edit||
|`/user/question/ask`|question_ask|Formulaire création de question|POST|QuestionController|form||
|`/user/question/answer/{id}/validate`|answer_validate|Valider la bonne réponse à une question|POST|AnswerController|validate||
|`/backend/question/[id]/toggle`|backend_question_toggle|Bloquer /débloquer une question|POST|Backend\QuestionController|toggle||
|`/backend/question/answer/[id]/toggle`|backend_answer_toggle|Bloquer/débloquer une réponse à une question|POST|Backend\AnswerController|toggle||
|`/backend/users`|backend_users_list|Permet à un admin de consulter les users|POST|Backend\UserController|list||
|`/backend/users/[id]/role`|backend_users_role|Permet à un admin de modifier le role d'un user|POST|Backend\UserController|toggleRole||
|`/backend/tag/list`|backend_tag_list|liste des tags|GET|Backend\TagController|list||
|`/backend/tag/new`|backend_tag_new|Créer un tag|POST|TagController|form|Méthode commune creation update|
|`/backend/tag/[id]/edit`|backend_tag_edit|Modifier un tag|POST|TagController|form||
|`/backend/tag/[id]/delete`|backend_tag_delete|Supprimer un tag|POST|TagController|delete||