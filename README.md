# E-Boutique BD

Projet de site e-commerce pour la vente de bandes dessinées.

## Liens utiles

* **Site en production :** [https://eboutique-bd.alwaysdata.net/](https://eboutique-bd.alwaysdata.net/)
* **Code source :** [https://github.com/saiyanjin/eboutique-bd](https://github.com/saiyanjin/eboutique-bd)

---

## État des fonctionnalités

Voici le récapitulatif du projet.

### Ce qui fonctionne (OK)
* **Authentification** : Système de connexion (Login) opérationnel.
* **Navigation** : 
    * Parcours des articles par catégorie.
    * Consultation de la liste complète des articles.
* **Gestion du panier** :
    * Ajout d'articles au panier.
    * Ajustement des quantités dans le panier avec mise à jour dynamique du prix total.
* **Commande** : Validation du panier et affichage du message de confirmation de commande effectuée.
* **Back-Office (Admin)** :
    * Ajout de nouveaux types d'articles (Gestion du stock non requise).
    * Création et gestion de nouvelles catégories.

### En cours ou à améliorer (NOK)
* **Inscription** : Le formulaire d'inscription a besoin de l'implémentation du contrôle de majorité basé sur la date de naissance.
* **Profil Utilisateur** : La fonctionnalité de mise à jour des informations du profil pour le client connecté.

---

## Stack Technique

* **Framework** : Symfony 
* **Langage** : PHP 8.2
* **Base de données** : MySQL / MariaDB
* **Interface Admin** : EasyAdmin 
* **Hébergement** : Alwaysdata

---
