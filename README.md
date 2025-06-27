# FlashcardPro

FlashcardPro is a web application built with Laravel and Livewire, enabling users to register, create and manage cards, organize them into decks, study cards, and access card data via a secure API.

## Author

-   **Name**: Harish Chauhan
-   **Email**: harish282@gmail.com

## Technologies Used

-   **PHP**: 8.2
-   **Laravel**: 12.x
-   **Livewire**: 3.x
-   **Tailwind CSS**: 3.x
-   **Sanctum**: For API authentication
-   **SQLite**: Database
-   **Pest/PHPUnit**: For testing

## Setup Instructions

This is a standard Laravel project. Follow these steps to set it up locally:

1. **Clone the Repository**:

    ```bash
    git clone https://github.com/harish282/learning-flashcard-pro
    cd flashcardpro
    ```

2. **Install Composer Dependencies**:

    ```bash
    composer install
    ```

3. **Install NPM Dependencies**:

    ```bash
    npm install
    npm run build
    ```

4. **Set Up Environment**:

    ```bash
    cp .env.example .env
    ```

    Configure `.env` for SQLite and Sanctum:

    ```
    DB_CONNECTION=sqlite
    SESSION_DOMAIN=localhost
    SANCTUM_STATEFUL_DOMAINS=localhost
    ```

    Create the SQLite database file:

    ```bash
    touch database/database.sqlite
    ```

5. **Generate Application Key**:

    ```bash
    php artisan key:generate
    ```

6. **Run Migrations and Seeders**:

    ```bash
    php artisan migrate --seed
    ```

7. **Start the Development Server**:
    ```bash
    php artisan serve --host=localhost
    ```
    Access the app at `http://localhost:8000`.

## Running the Test Suite

To execute the test suite:

```bash
php artisan test
```

Ensure the database is migrated and seeded before running tests.

## Architectural Decisions and Assumptions

-   **Livewire**: Chosen for real-time UI interactions in card/deck management and study features, avoiding a separate frontend framework.
-   **Sanctum**: Implemented for API authentication to secure `/api/decks/{deck}/cards`.
-   **SQLite**: Selected for ease of development, compatible with other databases.
-   **Authorization**: Used `DeckPolicy` to restrict access to user-owned or public decks.
-   **Assumption**: Study feature displays cards randomly with answer toggling, assuming a basic self-testing approach.

## AI Tool Usage Disclosure

Grok 3, created by xAI, was used to assist in generating code, writing tests, and creating this README. All outputs were reviewed to ensure compliance with Laravel 12 conventions and project requirements.
