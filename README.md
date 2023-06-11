Rezervační systém - EPU část
===
## Jak program funguje?
Po odeslání formuláře program zkontroluje, zda je ve stejný čas rezervovaných míst méně jak 20, víc míst totiž naše kavárna nemá.

- Předpokládáme že má kavárna více míst, je ale ochotná rezervovat jen 20 vyhrazených na rezervaci.
- Předpokládáme že všichni hosté přijou přesně jak si to zarezervují.
- Předpokládáme, že si zákazníci rezervují vždy stůl od celé hodiny do celé hodiny

PHP funkce překontroluje tedy místa v daný čas a podle toho vyhodí alert 
- "Rezervace odeslána"
- "Rezervaci nebylo možné uskutečnit - není dostatek volných míst"

V databázovém sloupci status máme tři možné hodnoty
- 0: Vyřízeno, přijato
- 1: Čeká na vyřízení
- 2: Zamítnuto

Pomocí odkzau s hodnotou GET "login=admin" (test.trnass.cz?login=admin) se dostaneme do administrace, tam můžeme vesele potvrzovat či zamítat žádosti o rezervace.

## Rozmístění jednotlivých souborů
```
|—— admin.php
|—— config.php
|—— db.php
|—— index.php
```
### Užitý software
  ```
  OS: Debian 11 BullsEye
  DB: PhpMyAdmin - MariaDB
  PHP: 7.4
  BootStrap: 5.0
  ```

### Vytvoření stejné db pomocí příkazu
```
CREATE TABLE `rezervace` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT 'jméno',
  `surname` varchar(32) NOT NULL COMMENT 'přijmení',
  `mail` varchar(128) NOT NULL COMMENT 'mail',
  `customers` int(2) NOT NULL COMMENT 'počet zákazníků',
  `time` varchar(32) NOT NULL COMMENT 'čas ve formátu HH:MM',
  `date` varchar(32) NOT NULL COMMENT 'datum ve formátu DDMMRRRR',
  `note` varchar(255) NOT NULL DEFAULT 'Bez poznámky' COMMENT 'poznámka max 255 znaků',
  PRIMARY KEY (`id`)
);
```
## Odkud jsem čerpal informace?
- PHP 7.4
  - Oficialní dokumentace
- SQL 
  - N/A
- BootStrap 5.0
  - Oficialní dokumentace a materiály
## Databáze?
Přístup do databáze je sice napsaný v kódu, nicméně on se neztratí ani tady v README.
- Username: school
- Password: Aa123456Bb654321
- Umístění: [PhpMyAdmin](https://database.trnass.cz/)

## Citát na závěr
```
Programování je moje rozcvička, debugování je moje kardio.
```
