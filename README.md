# STS CLI Package

**STS CLI** este o aplicație de linie de comandă (CLI) robustă pentru gestionarea migrărilor bazei de date, gestionarea pluginurilor și alte funcționalități utile pentru dezvoltatori. Această aplicație este construită folosind PHP și oferă o gamă largă de comenzi pentru a facilita diverse operațiuni de administrare.

## Cuprins

- [Instalare](#instalare)
- [Utilizare](#utilizare)
  - [Comenzi disponibile](#comenzi-disponibile)
  - [Argumente și opțiuni](#argumente-și-opțiuni)
- [Exemple](#exemple)
- [Contribuție](#contribuție)
- [Licență](#licență)

## Instalare

1. **Clonează depozitul:**

   ```sh
   git clone https://github.com/username/mycli.git
   cd sts/cli
   ```
2. **Instalează dependențele folosind Composer:**
   ```sh
   composer install
   ```
3. **Asigură-te că fișierul CLI este executabil:**
    ```sh
    chmod +x bin/cli.php
    ```

## Utilizare
Pentru a utiliza aplicația CLI, navighează la directorul rădăcină al proiectului și rulează:

  ```sh
  php bin/cli.php [comanda] [opțiuni]
  ```

## Comenzi disponibile

  * ``help:`` Afișează lista de comenzi disponibile și informații despre utilizarea aplicației.
  * ``migrate:run:`` Rulează toate migrațiile disponibile.
  * ``migrate:check:`` Verifică starea migrațiilor.
  * ``migrate:rollback:`` Anulează ultima migrare aplicată.
  * ``migrate:run --force:`` Rulează toate migrațiile, indiferent de starea lor.
  * ``plugin:create [nume_plugin] [tip_plugin]``: Creează un nou plugin cu structura specificată

## Argumente și Opțiuni
``--force``: Forțează rularea unei acțiuni (de exemplu, ``migrate:run --force`` va aplica toate migrațiile, chiar dacă au fost deja aplicate).

``--help`` sau ``-h``: Afișează ajutor pentru o comandă specifică.

## Exemple
### Rulează migrațiile

Pentru a rula toate migrațiile:
```sh
php bin/cli.php migrate:run
```

Pentru a forța rularea tuturor migrațiilor:
```sh
php bin/cli.php migrate:run --force
```

### Verifică starea migrărilor
Pentru a verifica dacă există migrații care trebuie aplicate:

```sh
php bin/cli.php migrate:check
```

### Creează un plugin
Pentru a crea un nou plugin:
```sh
php bin/cli.php plugin:create MyPlugin module [widget]
```

##  Contribuție
Contribuțiile sunt binevenite! Urmează pașii de mai jos pentru a contribui:

Forkează acest depozit.
Creează un branch pentru noua ta funcționalitate (``git checkout -b feature/noua-funcționalitate``).

Fă commit la modificările tale (``git commit -m 'Adaugă o nouă funcționalitate'``).

Fă push la branch-ul tău (``git push origin feature/noua-funcționalitate``).

Deschide un Pull Request.

Te rugăm să consulți CONTRIBUTING.md pentru mai multe detalii.

## Licență
Acest proiect este licențiat sub licența MIT - vezi fișierul LICENSE pentru detalii.
