<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use function Sodium\add;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201230005727 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Creates starter categories and subcategories for menu';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('INSERT INTO category (id, name, visible, weight) values (1, \'Przystawki\', 1, 1)');
        $this->addSql('INSERT INTO category (id, name, visible, weight) values (2, \'Dania główne\', 1, 1)');
        $this->addSql('INSERT INTO category (id, name, visible, weight) values (3, \'Desery\', 1, 1)');
        $this->addSql('INSERT INTO category (id, name, visible, weight) values (4, \'Napoje gorące\', 1, 1)');
        $this->addSql('INSERT INTO category (id, name, visible, weight) values (5, \'Napoje zimne\', 1, 1)');
        $this->addSql('INSERT INTO category (id, name, visible, weight) values (6, \'Alkohole\', 1, 1)');


        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (1, 1, \'Słone\', 1)');
        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (2, 1, \'Owoce morza\', 1)');
        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (3, 1, \'Pieczywo\', 1)');


        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (4, 2, \'Zupy\', 1)');
        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (5, 2, \'Makarony\', 1)');
        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (6, 2, \'Pizza\', 1)');
        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (7, 2, \'Tradycyjne\', 1)');

        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (8, 3, \'Ciasta\', 1)');
        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (9, 3, \'Lody\', 1)');
        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (10, 3, \'Owocowe\', 1)');


        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (11, 4, \'Kawy\', 1)');
        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (12, 4, \'Herbaty\', 1)');
        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (13, 4, \'Zupy\', 1)');

        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (14, 5, \'Soki\', 1)');
        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (15, 5, \'Soki wyciskane\', 1)');
        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (16, 5, \'Gazowane\', 1)');
        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (17, 5, \'Wody\', 1)');

        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (18, 6, \'Wódki\', 1)');
        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (19, 6, \'Wina\', 1)');
        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (20, 6, \'Whisky\', 1)');
        $this->addSql('INSERT INTO subcategory (id, category_id, name, visible) values (21, 6, \'Drinki\', 1)');

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DELETE FROM category WHERE id = 1');
        $this->addSql('DELETE FROM category WHERE id = 2');
        $this->addSql('DELETE FROM category WHERE id = 3');
        $this->addSql('DELETE FROM category WHERE id = 4');
        $this->addSql('DELETE FROM category WHERE id = 5');
        $this->addSql('DELETE FROM category WHERE id = 6');

        $this->addSql('DELETE FROM subcategory WHERE id = 1');
        $this->addSql('DELETE FROM subcategory WHERE id = 2');
        $this->addSql('DELETE FROM subcategory WHERE id = 3');
        $this->addSql('DELETE FROM subcategory WHERE id = 4');
        $this->addSql('DELETE FROM subcategory WHERE id = 5');
        $this->addSql('DELETE FROM subcategory WHERE id = 6');
        $this->addSql('DELETE FROM subcategory WHERE id = 7');
        $this->addSql('DELETE FROM subcategory WHERE id = 8');
        $this->addSql('DELETE FROM subcategory WHERE id = 9');
        $this->addSql('DELETE FROM subcategory WHERE id = 10');
        $this->addSql('DELETE FROM subcategory WHERE id = 11');
        $this->addSql('DELETE FROM subcategory WHERE id = 12');
        $this->addSql('DELETE FROM subcategory WHERE id = 13');
        $this->addSql('DELETE FROM subcategory WHERE id = 14');
        $this->addSql('DELETE FROM subcategory WHERE id = 15');
        $this->addSql('DELETE FROM subcategory WHERE id = 16');
        $this->addSql('DELETE FROM subcategory WHERE id = 18');
        $this->addSql('DELETE FROM subcategory WHERE id = 19');
        $this->addSql('DELETE FROM subcategory WHERE id = 20');
        $this->addSql('DELETE FROM subcategory WHERE id = 21');
    }
}
