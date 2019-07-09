| URL | Name | Description de la page | Méthode HTTP | Controller | Méthode | commentaire |
|--|--|--|--|--|--|--|
| `/` | question_list | Liste des questions | GET | QuestionController | list | Page d'accueil avec les questions récentes |
| `/question/[id]` | question_show | La question avec ses réponses | GET | QuestionController | show | question et ses réponses selon son id |
|`/question/ask`|question_ask|Formulaire création de question|POST|QuestionController|form|Même méthode pour création et edit de la question|
|`/question/[id]/edit`|question_edit|Formulaire pour edit une question|POST|QuestionController|form||
|`/question/[id]/delete`|question_delete|Supprimer une question|POST|QuestionController|delete||
|`/question/[id]/SwitchStatus`|question_switchStatus|Bloquer /débloquer une question|POST|AdminController|switchStatus||
|`/question/[id]/answer/submit`|answer_submit|Répondre à une question|POST|AnswerController|form||
|`/question/[id]/answer/[id]/edit`|answer_edit|Modifier sa réponse à une question|POST|AnswerController|form||
|`/question/[id]/answer/[id]/delete`|answer_delete|Supprimer une réponse à une question|POST|AnswerController|delete||
|`/question/[id]/answer/[id]/status`|answer_switchStatus|Bloquer/débloquer une réponse à une question|POST|AdminController|switchStatus||
|`/signup`|sign_up|formulaire d'inscription|GET/POST|UserController|signUp||
`/login`|log_in|Formulaire de connexion|GET/POST|UserController|login||
`/profile`|profile_show|Informations du compte et liste questions et réponses de l'utilisateur|GET|UserController|show||
`/profile/edit`|profile_edit|Modifiction des informations perso du compte utilisateur|POST|UserController|edit||

