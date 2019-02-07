Table Votes
==========================
id       cle primaire
ref_id   identifiant(id) de la table (version la table en cours)
ref      nom de la table elle meme
user_id  identifiant d'utilisateur ayant vote
vote     qui sauvegarde l'etat du vote Like ou dislike
....
on peut ajouter d'autres champs comme l'ip du client




le champ user_id peut etre remplacer par l'ip 
cad on sauvegarde l'ip du client en base de donnees

mais dans notre cas pour voter on authentifie l'utilisateur


TESTER REQUETE 
=====================================
SELECT COUNT(id), vote FROM votes GROUP BY vote



