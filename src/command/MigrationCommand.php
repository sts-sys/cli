<?php
namespace sts\cli\command;

use sts\cli\BaseCommand;
use PDO;
use Exception;

class MigrationCommand extends BaseCommand
{
    private $pdo;

    public function __construct()
    {
        // Conectare la baza de date
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=nume_baza_de_date", "utilizator", "parola");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            $this->displayError("Eroare la conectarea la baza de date: " . $e->getMessage());
            exit(1);
        }
    }

    public function run(array $args): void
    {
        $command = $args[0] ?? null;

        switch ($command) {
            case 'migrate:run':
                $force = in_array('--force', $args);
                $this->runMigrations($force);
                break;
            case 'migrate:check':
                $this->checkMigrations();
                break;
            case 'migrate:rollback':
                $this->rollbackMigration();
                break;
            default:
                $this->displayError("Comandă necunoscută. Utilizare: migrate:run, migrate:check, migrate:rollback, migrate:run --force");
                break;
        }
    }

    private function runMigrations(bool $force = false): void
    {
        try {
            // Obține toate fișierele de migrare disponibile
            $migrations = glob(__DIR__ . '/../../../migrations/*.php');
            $appliedMigrations = $this->getAppliedMigrations();

            foreach ($migrations as $migration) {
                $migrationName = basename($migration, '.php');

                if (!in_array($migrationName, $appliedMigrations) || $force) {
                    echo "Aplic migrarea: $migrationName\n";
                    $migrationFunction = include $migration;
                    $migrationFunction($this->pdo);
                    $this->markMigrationAsApplied($migrationName);
                }
            }

            echo "Toate migrațiile au fost aplicate cu succes.\n";
        } catch (Exception $e) {
            $this->displayError("Eroare la aplicarea migrărilor: " . $e->getMessage());
        }
    }

    private function checkMigrations(): void
    {
        $migrations = glob(__DIR__ . '/../../../migrations/*.php');
        $appliedMigrations = $this->getAppliedMigrations();
        $pendingMigrations = [];

        foreach ($migrations as $migration) {
            $migrationName = basename($migration, '.php');

            if (!in_array($migrationName, $appliedMigrations)) {
                $pendingMigrations[] = $migrationName;
            }
        }

        if (empty($pendingMigrations)) {
            echo "Toate migrațiile au fost aplicate.\n";
        } else {
            echo "Migrații care trebuie aplicate:\n";
            foreach ($pendingMigrations as $migration) {
                echo " - $migration\n";
            }
        }
    }

    private function rollbackMigration(): void
    {
        try {
            // Obține ultima migrare aplicată
            $lastMigration = $this->getLastAppliedMigration();

            if (!$lastMigration) {
                echo "Nu există migrații pentru rollback.\n";
                return;
            }

            echo "Revin la migrarea: $lastMigration\n";
            $migrationPath = __DIR__ . '/../../../migrations/' . $lastMigration . '.php';
            if (file_exists($migrationPath)) {
                $migrationFunction = include $migrationPath;
                if (is_callable([$migrationFunction, 'rollback'])) {
                    $migrationFunction::rollback($this->pdo);
                    $this->markMigrationAsRolledBack($lastMigration);
                    echo "Migrarea $lastMigration a fost anulată cu succes.\n";
                } else {
                    echo "Migrarea $lastMigration nu are o funcție de rollback definită.\n";
                }
            } else {
                echo "Fișierul de migrare pentru $lastMigration nu a fost găsit.\n";
            }
        } catch (Exception $e) {
            $this->displayError("Eroare la rollback-ul migrărilor: " . $e->getMessage());
        }
    }

    private function getAppliedMigrations(): array
    {
        $stmt = $this->pdo->query("SELECT migration FROM migrari_aplicate");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    private function getLastAppliedMigration(): ?string
    {
        $stmt = $this->pdo->query("SELECT migration FROM migrari_aplicate ORDER BY applied_at DESC LIMIT 1");
        return $stmt->fetchColumn() ?: null;
    }

    private function markMigrationAsApplied(string $migration): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO migrari_aplicate (migration) VALUES (:migration)");
        $stmt->execute(['migration' => $migration]);
    }

    private function markMigrationAsRolledBack(string $migration): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM migrari_aplicate WHERE migration = :migration");
        $stmt->execute(['migration' => $migration]);
    }
}
