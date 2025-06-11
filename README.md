# Test Technique — Recommandation de vêtements selon la météo

Ce projet a été réalisé dans le cadre d’un **test technique** visant à construire une API de recommandation de vêtements, en fonction de la météo d'une ville donnée.

L'objectif était de permettre à une équipe marketing de cibler les produits à recommander selon les conditions météo locales.

---

## Ce que j'ai développé

✔️ Une API Symfony propre, découpée et testée, qui expose les routes:

-   `/clothe/{city}` : retourne une liste de vêtements selon la température dans une ville
-   `?date=today|tomorrow` : permet de demander la météo du jour ou du lendemain

✔️ Un appel réel à l’API météo [WeatherAPI](https://www.weatherapi.com/) via un service dédié (`WeatherService`)

✔️ Une logique métier claire, isolée dans un service `ClotheRecommendationService`

✔️ Une gestion des erreurs propre (ville inconnue, aucun produit associé, etc.)

✔️ Des **fixtures prêtes à l’emploi** pour remplir automatiquement la base de données avec :

-   3 types de vêtements (`pull`, `sweat`, `t-shirt`) selon la température
-   Des vêtements générés dynamiquement avec Faker

✔️ Des **tests automatisés** :

-   Unitaires sur le service météo
-   Fonctionnels sur l’API `/clothe/{city}`
-   Intégrés à GitHub Actions via un fichier `.github/workflows/ci-test.yml`

---

## ⚙️ Installation

### 1. Cloner le projet

```bash
git clone https://github.com/toncompte/api-test-technique-sf.git
cd api-test-technique-sf
```

### 2. Installer les dépendances

```bash
composer install
```

### 3. Configurer l'environnement local

Crée un fichier .env.local :

```bash
WEATHER_API_KEY=api_key
DATABASE_URL="postgresql://user@localhost:5432/dbname?serverVersion=14&charset=utf8"
```

Ou une autre base de données.

### 4. Lancer les migrations et charger les fixtures

Crée un fichier .env.local :

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

### Démarrer le projet en local

Avec Symfony CLI :

```bash
symfony server:start
```

## Exemple d’appel API

```http
GET /clothe/Paris
GET /clothe/Marseille?date=tomorrow
```

## Réponse :

```
{
  "products": [
    { "id": 1, "name": "Tshirt bleu", "price": 20 },
    { "id": 2, "name": "Tshirt rouge", "price": 20 }
  ],
  "weather": {
    "city": "Marseille",
    "is": "hot",
    "date": "tomorrow"
  }
}
```

## Lancer les tests

```
php bin/phpunit
```

## CI intégrée

Le projet contient un workflow GitHub Actions `.github/workflows/ci-test.yml` qui :

✔️ Installe les dépendances
✔️ Prépare la base PostgreSQL de test
✔️ Lance les migrations & fixtures
✔️ Exécute les tests

Pour exécuter les tests avec la CI, il est impératif d'avoir mis dans les github secrets du repository la variable `WEATHER_API_KEY` qui contient la clef API de WeatherAPI.

## 📁 Arborescence utile

```
src/
├── Controller/ClotheController.php
├── Service/WeatherService.php
├── Service/ClotheRecommendationService.php
tests/
├── Service/WeatherServiceTest.php
├── Controller/ClotheControllerTest.php
```

## ✍️ Auteur

Lucas Boillot — Développé dans le cadre d’un test technique Symfony ☁️
