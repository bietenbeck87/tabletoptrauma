-- phpMyAdmin SQL Dump
-- version 4.2.12
-- http://www.phpmyadmin.net
--
-- Host: rdbms
-- Erstellungszeit: 30. Mrz 2017 um 10:50
-- Server Version: 5.5.52-log
-- PHP-Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `DB1842893`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `brettspiele`
--

CREATE TABLE IF NOT EXISTS `brettspiele` (
  `ID` int(11) unsigned NOT NULL,
  `NAME` varchar(255) DEFAULT NULL,
  `MIN_P` int(11) DEFAULT NULL,
  `MAX_P` int(11) DEFAULT NULL,
  `ERWEITERUNG` int(11) DEFAULT NULL,
  `SPRACHE` varchar(255) DEFAULT NULL,
  `KOOP` int(11) DEFAULT NULL,
  `URL` varchar(255) DEFAULT NULL,
  `GENRE` varchar(255) DEFAULT NULL,
  `BILD` varchar(255) DEFAULT NULL,
  `BESITZER` varchar(255) DEFAULT NULL,
  `MIN_T` int(11) DEFAULT NULL,
  `MAX_T` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `brettspiele`
--

INSERT INTO `brettspiele` (`ID`, `NAME`, `MIN_P`, `MAX_P`, `ERWEITERUNG`, `SPRACHE`, `KOOP`, `URL`, `GENRE`, `BILD`, `BESITZER`, `MIN_T`, `MAX_T`) VALUES
(100, 'Arkham Horror : Kartenspiel', 1, 2, NULL, 'Deutsch', 1, 'https://boardgamegeek.com/boardgame/205637/arkham-horror-card-game', 'Horror||Chutulhu', 'https://cf.geekdo-images.com/xW22wt5_wk_8sWLsVR_5E4t2v-g=/fit-in/246x300/pic3122349.jpg', 'Marcel', 60, 120),
(200, 'Gears of War', 1, 4, NULL, 'Englisch', 1, 'https://boardgamegeek.com/boardgame/42776/gears-war-board-game', 'Horror||Alien||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/jmo4Y0aL51x2tclVUc5PA645U7g=/fit-in/246x300/pic1004112.jpg', 'Marcel', 60, 180),
(300, 'Projekt:Elite', 1, 4, NULL, 'Englisch', 1, 'https://boardgamegeek.com/boardgame/171726/project-elite', 'Horror||Alien||Miniaturen', 'https://cf.geekdo-images.com/Cw0A3UEZEx_Ee4jDHm6FI2FQnhM=/fit-in/246x300/pic2853683.jpg', 'Marcel', 30, 45),
(301, 'Adrenalin', 1, 4, 300, 'Englisch', 1, 'https://boardgamegeek.com/boardgameexpansion/178032/project-elite-adrenaline', 'Horror||Alien', 'https://cf.geekdo-images.com/GrKX23gMsZxVviYXfb1QCtDj7HY=/fit-in/246x300/pic2624151.jpg', 'Marcel', 30, 45),
(302, 'Elite Pack', 1, 4, 300, 'Englisch', 1, 'https://boardgamegeek.com/boardgameexpansion/182054/project-elite-alien-pack', 'Horror||Alien', 'https://cf.geekdo-images.com/27BCkDjgxHNPi583cYfHOH_yBF8=/fit-in/246x300/pic2624274.jpg', 'Marcel', 30, 45),
(303, 'Mega Boss Bundle', 1, 4, 300, 'Englisch', 1, 'https://boardgamegeek.com/boardgameexpansion/182055/project-elite-mega-boss-bundle', 'Horror||Alien', 'https://cf.geekdo-images.com/ytgjvLK4M5aIfP6bmH2bE7mUxBU=/fit-in/246x300/pic3224653.jpg', 'Marcel', 30, 45),
(400, 'Ghost Stories', 1, 4, NULL, 'Deutsch', 1, 'https://boardgamegeek.com/boardgame/37046/ghost-stories', 'Horror||Geister', 'https://cf.geekdo-images.com/DdGkRcbGX2vhGfpA-pzjUr4xF24=/fit-in/246x300/pic1790243.jpg', 'Marcel', 60, 70),
(500, 'Fireteam: Zero', 1, 4, NULL, 'Deutsch', 1, 'https://boardgamegeek.com/boardgame/149776/fireteam-zero', 'Horror||Miniaturen', 'https://cf.geekdo-images.com/uOM7AuzxyzXBSVSij0Y1fzQ2O2M=/fit-in/246x300/pic2208055.jpg', 'Marcel', 90, 120),
(600, 'Dungeon Saga', 1, 5, NULL, 'Deutsch', 2, 'https://boardgamegeek.com/boardgame/160081/dungeon-saga-dwarf-kings-quest', 'Fantasy||Mittelalter||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/l46TtbPT0xjZJ7DiBijFA-RS-3Q=/fit-in/246x300/pic2619701.jpg', 'Marcel', 30, 120),
(700, 'Lobotomy', 1, 5, NULL, 'Englisch', 1, 'https://boardgamegeek.com/boardgame/173805/lobotomy', 'Horror||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/onF54BIVXvJspr82tHbzahOgHSc=/fit-in/246x300/pic3449059.jpg', 'Marcel', 60, 180),
(701, 'From the Deep', 1, 5, 700, 'Englisch', 1, 'https://boardgamegeek.com/boardgameexpansion/221043/lobotomy-deep', 'Horror||Chutulhu||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/aobaW_3lljVWpEmrLbspGbub_aA=/fit-in/246x300/pic3449064.jpg', 'Marcel', 60, 180),
(800, 'Villen des Wahnsinns 2nd Edition', 1, 5, NULL, 'Deutsch', 1, 'https://boardgamegeek.com/boardgame/205059/mansions-madness-second-edition', 'Horror||Chutulhu||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/B0F4U1vQnELePmNg4n5dtvcryGU=/fit-in/246x300/pic3118622.jpg', 'Marcel', 120, 180),
(801, 'UnterdrÃ¼ckte Erinnerungen', 1, 5, 800, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/206548/mansions-madness-second-edition-suppressed-memorie', 'Horror||Chutulhu||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/k3IwUpLMPg4YoumpVjEPLzaL6zk=/fit-in/246x300/pic3238295.jpg', 'Marcel', 120, 180),
(900, 'UNLOCK!', 1, 6, NULL, 'Deutsch', 1, 'https://boardgamegeek.com/boardgame/213460/unlock', 'Escape||Logik', 'https://cf.geekdo-images.com/o1PM_RNLP721yNFmZX-SRieWpis=/fit-in/246x300/pic3348790.jpg', 'Marcel', 45, 75),
(1000, 'Dungeon Fighter', 1, 6, NULL, 'Deutsch', 1, 'https://boardgamegeek.com/boardgame/102548/dungeon-fighter', 'WÃ¼rfel-Spiel||Agility', 'https://cf.geekdo-images.com/JeUYw0wO6iyVKBCGym3lxxYYxpQ=/fit-in/246x300/pic2411495.png', 'Marcel', 45, 60),
(1100, 'B-Sieged', 1, 6, NULL, 'Englisch', 1, 'https://boardgamegeek.com/boardgame/164865/b-sieged-sons-abyss', 'Fantasy||Mittelalter||Miniaturen', 'https://cf.geekdo-images.com/lzC_JNmCB8eUqlZwMr9tt8PertI=/fit-in/246x300/pic2511743.jpg', 'Marcel', 60, 90),
(1200, 'Die Schlachten von Westeros', 2, 2, NULL, 'Deutsch', 0, 'https://boardgamegeek.com/boardgame/67492/battles-westeros', 'Fantasy||Mittelalter||Miniaturen', 'https://cf.geekdo-images.com/auK-HSCXK6H1XZXBFf1sGvaRqoA=/fit-in/246x300/pic711013.jpg', 'Marcel', 60, 120),
(1201, 'Haus Baratheon', 2, 2, 1200, 'Deutsch', 0, 'https://boardgamegeek.com/boardgameexpansion/123847/battles-westeros-house-baratheon-army-expansion', 'Fantasy||Mittelalter||Miniaturen', 'https://cf.geekdo-images.com/KdmAMciLOojGPqPAl8fdqHxuzWo=/fit-in/246x300/pic1323906.jpg', 'Marcel', 60, 120),
(1202, 'Wächter des Nordens', 2, 2, 1200, 'Deutsch', 0, 'https://boardgamegeek.com/boardgameexpansion/77849/battles-westeros-wardens-north', 'Fantasy||Mittelalter||Miniaturen', 'https://cf.geekdo-images.com/M2j3N1HhGd02xqJr9KODQDT_qcM=/fit-in/246x300/pic883240.jpg', 'Marcel', 60, 120),
(1203, 'Wächter des Westens', 2, 2, 1200, 'Deutsch', 0, 'https://boardgamegeek.com/boardgameexpansion/71493/battles-westeros-wardens-west', 'Fantasy||Mittelalter||Miniaturen', 'https://cf.geekdo-images.com/6741kV41BWBkCt1d1vAXWvPYa0g=/fit-in/246x300/pic883238.jpg', 'Marcel', 60, 120),
(1204, 'Herren der Flusslande', 2, 2, 1200, 'Deutsch', 0, 'https://boardgamegeek.com/boardgameexpansion/88926/battles-westeros-lords-river', 'Fantasy||Mittelalter||Miniaturen', 'https://cf.geekdo-images.com/qgnlQh3RL47GxVaffTKzBVU4Kb0=/fit-in/246x300/pic991170.jpg', 'Marcel', 60, 120),
(1300, 'Maus und Mystik', 2, 4, NULL, 'Deutsch', 1, 'https://boardgamegeek.com/boardgame/124708/mice-and-mystics', 'Fantasy||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/zKvtC4E0HL5p0SgZF9E9jyyc0Iw=/fit-in/246x300/pic1312072.jpg', 'Marcel', 90, 120),
(1301, 'Herz des Glürms', 2, 4, 1300, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/144777/mice-and-mystics-heart-glorm', 'Fantasy||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/XHjZwjyOksuGUCKU3r40wlsqAUs=/fit-in/246x300/pic1709639.jpg', 'Marcel', 90, 120),
(1302, 'Geschichten aus dem Dunkelwald', 2, 4, 1300, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/159458/mice-and-mystics-downwood-tales', 'Fantasy||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/5neYogRUoiRlC_10Pz7W1wU3tg4=/fit-in/246x300/pic2038331.jpg', 'Marcel', 90, 120),
(1400, 'Robinson Crusoe', 2, 4, NULL, 'Deutsch', 1, 'https://boardgamegeek.com/boardgame/121921/robinson-crusoe-adventures-cursed-island', 'Escape', 'https://cf.geekdo-images.com/SwEANI20X35SeJFFNVVCJwlTuk4=/fit-in/246x300/pic3165731.jpg', 'Marcel', 90, 180),
(1401, 'Die Fahrt der Beagle', 2, 4, 1400, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/144722/robinson-crusoe-adventures-cursed-island-voyage-be', 'Escape', 'https://cf.geekdo-images.com/SY4dpxrZFmM7I1lYPDf0w26tTT0=/fit-in/246x300/pic1997048.jpg', 'Marcel', 90, 180),
(1500, 'Shadows of Brimstone: City of the Ancients', 2, 4, NULL, 'Englisch', 1, 'https://boardgamegeek.com/boardgame/146791/shadows-brimstone-city-ancients', 'Horror||Chutulhu||Dungeon||Miniaturen||Western', 'https://cf.geekdo-images.com/_1tjYQzanV18gfm9uL-US6nw4xk=/fit-in/246x300/pic2037825.jpg', 'Marcel||Alex', 90, 120),
(1600, 'T.I.M.E. Stories', 2, 4, NULL, 'Deutsch', 1, 'https://boardgamegeek.com/boardgame/146508/time-stories', 'Escape||Fantasy||Horror||Logik', 'https://cf.geekdo-images.com/QLBjrX0LZsJl5dDRreXz0BA1FM4=/fit-in/246x300/pic2617634.png', 'Marcel', 90, 180),
(1601, 'Hinter der Maske', 2, 4, 1600, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/189686/time-stories-under-mask', 'Fantasy||Logik', 'https://cf.geekdo-images.com/mWnOmkF0hCYUZBY6kHGj4zjeMuQ=/fit-in/246x300/pic3013618.jpg', 'Marcel', 90, 180),
(1602, 'Der Marcy-Fall', 2, 4, 1600, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/180585/time-stories-marcy-case', 'Horror||Zombies||Escape||Logik', 'https://cf.geekdo-images.com/nJ-pP6bYCq2OjKaGvhrhJp0I76E=/fit-in/246x300/pic2617644.jpg', 'Marcel', 90, 180),
(1603, 'Die Drachen Prophezeiung', 2, 4, 1600, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/189035/time-stories-prophecy-dragons', 'Fantasy||Mittelalter||Logik', 'https://cf.geekdo-images.com/b9IBRtZksDPSQB691OPFyeHrjnQ=/fit-in/246x300/pic2793584.jpg', 'Marcel', 90, 180),
(1604, 'Die Endurance Expedition', 2, 4, 1600, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/193527/time-stories-expedition-endurance', 'Horror||Chutulhu||Logik', 'https://cf.geekdo-images.com/j3QnkOvbSFkJF-A2vdNV5uIEqhE=/fit-in/246x300/pic3300637.jpg', 'Marcel', 90, 180),
(1700, 'Krosmaster Arena', 2, 4, NULL, 'Deutsch', 0, 'https://boardgamegeek.com/boardgame/112138/krosmaster-arena', 'Fantasy||Miniaturen', 'https://cf.geekdo-images.com/VP7LC-CnBWmgtHDQq26rz-1iExU=/fit-in/246x300/pic1573355.png', 'Marcel', 60, 90),
(1701, 'Piwate', 2, 4, 1700, 'Deutsch', 0, 'https://boardgamegeek.com/boardgameexpansion/181413/krosmaster-arena-piwate-island', 'Fantasy||Miniaturen', 'https://cf.geekdo-images.com/KgGK6wOTL1RGMD0hre1-kf3OWw4=/fit-in/246x300/pic2606465.jpg', 'Marcel', 60, 90),
(1800, 'Arcadia Quest', 2, 4, NULL, 'Deutsch', 0, 'https://boardgamegeek.com/boardgame/155068/arcadia-quest', 'Fantasy||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/L6XdA4SrlVHmeqvRUR4BYzbEj_8=/fit-in/246x300/pic2305263.jpg', 'Marcel', 60, 90),
(1801, 'Jenseits der Gruft', 2, 4, 1800, 'Deutsch', 0, 'https://boardgamegeek.com/boardgameexpansion/156089/arcadia-quest-beyond-grave', 'Fantasy||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/urjHdK4SnOof6pg5NKAxFn3SLIY=/fit-in/246x300/pic2672519.jpg', 'Marcel', 60, 90),
(1900, 'Pandemie: Reign of Cthulhu', 2, 4, NULL, 'Deutsch', 1, 'https://boardgamegeek.com/boardgame/192153/pandemic-reign-cthulhu', 'Horror||Chutulhu||Miniaturen', 'https://cf.geekdo-images.com/Ue5J0-idkkZgIyAYx8r5ImHR1Cw=/fit-in/246x300/pic2866737.png', 'Marcel', 40, 60),
(2000, 'Mechs VS. Minions', 2, 4, NULL, 'Englisch', 1, 'https://boardgamegeek.com/boardgame/209010/mechs-vs-minions', 'Fantasy||Programmier-Spiel||Miniaturen', 'https://cf.geekdo-images.com/q32KDF-KFiI2ZP8POk-fh5v2JOI=/fit-in/246x300/pic3184103.jpg', 'Marcel', 60, 90),
(2100, 'Heroscape', 2, 4, NULL, 'Deutsch', 0, 'https://boardgamegeek.com/boardgame/11170/heroscape-master-set-rise-valkyrie', 'Fantasy||Miniaturen', 'https://cf.geekdo-images.com/Fq9ro-n3pMrmjYmJQZJNOmT_tFg=/fit-in/246x300/pic244662.jpg', 'Marcel', 90, 120),
(2200, 'Blood Rage', 2, 4, NULL, 'Deutsch', 0, 'https://boardgamegeek.com/boardgame/170216/blood-rage', 'Fantasy||Miniaturen', 'https://cf.geekdo-images.com/IBtRtMGWMXEXCVHroWqbbPT8I1g=/fit-in/246x300/pic2439223.jpg', 'Marcel', 60, 90),
(2300, 'Dead of Winter', 2, 5, NULL, 'Deutsch', 3, 'https://boardgamegeek.com/boardgame/150376/dead-winter-crossroads-game', 'Horror||Zombies', 'https://cf.geekdo-images.com/jEVYXajZNMo_82RJPKZRS8YR6k4=/fit-in/246x300/pic3016500.jpg', 'Marcel', 45, 210),
(2400, 'Dead of Winter: Die Lange Nacht', 2, 5, NULL, 'Deutsch', 3, 'https://boardgamegeek.com/boardgame/193037/dead-winter-long-night', 'Horror||Zombies', 'https://cf.geekdo-images.com/X08zDpEqv4VkSd7NICyC4GcgKyY=/fit-in/246x300/pic2906832.jpg', 'Marcel', 60, 120),
(2500, 'Villen des Wahnsinns', 2, 5, NULL, 'Deutsch', 2, 'https://boardgamegeek.com/boardgame/83330/mansions-madness', 'Horror||Chutulhu||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/7Ys6dvapQX_2rqY70zMrfkNZ7MI=/fit-in/246x300/pic814011.jpg', 'Marcel', 120, 180),
(2600, 'Grimoria', 2, 5, NULL, 'Deutsch', 0, 'https://boardgamegeek.com/boardgame/73863/grimoire', 'Fantasy', 'https://cf.geekdo-images.com/v-1U5BAx-cJpV_z6YB1j0Jui8X8=/fit-in/246x300/pic1040235.jpg', 'Marcel', 20, 30),
(2700, 'Dark Darker Darkest', 2, 5, NULL, 'Englisch', 1, 'https://boardgamegeek.com/boardgame/59429/dark-darker-darkest', 'Horror||Zombies||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/hUvts2pn1mfUiWUjhjPdFlvcCUQ=/fit-in/246x300/pic1429220.jpg', 'Marcel', 120, 150),
(2800, 'The Others: 7 Sins', 2, 5, NULL, 'Deutsch', 2, 'https://boardgamegeek.com/boardgame/172047/others', 'Horror||Dungeon||Miniaturen||SÃ¼nden', 'https://cf.geekdo-images.com/FeAlbJve54KEgjFVSl8ku308DJ0=/fit-in/246x300/pic2642988.jpg', 'Marcel', 90, 120),
(2801, 'Beta-Team', 2, 5, 2800, 'Englisch', 2, 'https://boardgamegeek.com/boardgameexpansion/186105/others-7-sins-beta-team-expansion', 'Horror||Dungeon||Miniaturen||SÃ¼nden', 'https://cf.geekdo-images.com/lJlwJ5uj-j4-eM286aDH9XnFg8Y=/fit-in/246x300/pic3297491.png', 'Marcel', 90, 120),
(2802, 'Omega-Team', 2, 5, 2800, 'Englisch', 2, 'https://boardgamegeek.com/boardgameexpansion/186106/others-7-sins-omega-team-expansion', 'Horror||Dungeon||Miniaturen||SÃ¼nden', 'https://cf.geekdo-images.com/2Q3KQDGZwgTBKBl9m5pKXXmJSwo=/fit-in/246x300/pic2698170.jpg', 'Marcel', 90, 120),
(2803, 'Lust', 2, 5, 2800, 'Englisch', 2, 'https://boardgamegeek.com/boardgameexpansion/186091/others-7-sins-lust-expansion', 'Horror||Dungeon||Miniaturen||SÃ¼nden', 'https://cf.geekdo-images.com/g5TmAi73VlWy9W2Mra3L1AEbSpc=/fit-in/246x300/pic3297461.png', 'Marcel', 90, 120),
(2804, 'Envy', 2, 5, 2800, 'Englisch', 2, 'https://boardgamegeek.com/boardgameexpansion/186094/others-7-sins-envy-expansion', 'Horror||Dungeon||Miniaturen||SÃ¼nden', 'https://cf.geekdo-images.com/83nRkXofmLstClcojlyGeZnKZ8E=/fit-in/246x300/pic3297473.png', 'Marcel', 90, 120),
(2805, 'Gluttony', 2, 5, 2800, 'Englisch', 2, 'https://boardgamegeek.com/boardgameexpansion/186090/others-7-sins-gluttony-expansion', 'Horror||Dungeon||Miniaturen||SÃ¼nden', 'https://cf.geekdo-images.com/LfHstmOcQxmTdjLKUcr3AH0rRl0=/fit-in/246x300/pic3297487.png', 'Marcel', 90, 120),
(2806, 'Wrath', 2, 5, 2800, 'Englisch', 2, 'https://boardgamegeek.com/boardgameexpansion/186093/others-7-sins-wrath-expansion', 'Horror||Dungeon||Miniaturen||SÃ¼nden', 'https://cf.geekdo-images.com/PHf3qfXoNDMmbfCJJwsf4WyX2sw=/fit-in/246x300/pic3297488.png', 'Marcel', 90, 120),
(2807, 'Greed', 2, 5, 2800, 'Englisch', 2, 'https://boardgamegeek.com/boardgameexpansion/186092/others-7-sins-greed-expansion', 'Horror||Dungeon||Miniaturen||SÃ¼nden', 'https://cf.geekdo-images.com/XyjBorQ8T3Cbbmg_fKatGUXgXeg=/fit-in/246x300/pic3297472.png', 'Marcel', 90, 120),
(2900, 'Roll for the Galaxy', 2, 5, NULL, 'Deutsch', 0, 'https://boardgamegeek.com/boardgame/132531/roll-galaxy', 'WÃ¼rfel-Spiel', 'https://cf.geekdo-images.com/Vi3pvbq9sLk_OHzxio8lzjB_77k=/fit-in/246x300/pic1473629.jpg', 'Marcel', 45, 60),
(3000, 'Zombicide', 2, 6, NULL, 'Deutsch', 1, 'https://boardgamegeek.com/boardgame/113924/zombicide', 'Horror||Zombies||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/H9jFY55jvouZOtkTPoc7gv_REf8=/fit-in/246x300/pic1196191.jpg', 'Marcel', 45, 180),
(3001, 'Toxic Mall', 2, 6, 3000, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/137987/zombicide-toxic-city-mall', 'Horror||Zombies||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/mYxim_HBQe_Z7lyoO_3aM5601dQ=/fit-in/246x300/pic1805936.jpg', 'Marcel', 45, 180),
(3002, 'Prison Outbreak', 2, 6, 3000, 'Deutsch', 1, 'https://boardgamegeek.com/boardgame/137988/zombicide-season-2-prison-outbreak', 'Horror||Zombies||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/gg-lKjfeuuChELJVqeeOn-rzUjA=/fit-in/246x300/pic1805937.jpg', 'Marcel', 45, 180),
(3003, 'Rue Morgue', 2, 6, 3000, 'Englisch', 1, 'https://boardgamegeek.com/boardgame/161866/zombicide-season-3-rue-morgue', 'Horror||Zombies||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/pnvhAjruZlOBWg_wNI2a7XNBH4Q=/fit-in/246x300/pic2066893.jpg', 'Marcel', 45, 180),
(3004, 'Angry Neighbors', 2, 6, 3000, 'Englisch', 1, 'https://boardgamegeek.com/boardgameexpansion/161920/zombicide-angry-neighbors', 'Horror||Zombies||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/vy2lal1LQRtBoHQVU2jIKt2R2E0=/fit-in/246x300/pic2067368.jpg', 'Marcel', 45, 180),
(3100, 'Zombicide: Black Plague', 2, 6, NULL, 'Deutsch', 1, 'https://boardgamegeek.com/boardgame/176189/zombicide-black-plague', 'Horror||Zombies||Mittelalter||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/TUTTLpuyVcvwcJIasTrbv3-48vY=/fit-in/246x300/pic2482309.jpg', 'Marcel', 60, 180),
(3101, 'Wulfsburg', 2, 6, 3100, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/178485/zombicide-wulfsburg', 'Horror||Zombies||Mittelalter||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/u756-QQX5buseQ85wsJnaRHs6CI=/fit-in/246x300/pic2552628.png', 'Marcel', 60, 180),
(3200, 'Legenden von Andor', 2, 6, NULL, 'Deutsch', 1, 'https://boardgamegeek.com/boardgame/127398/legends-andor', 'Fantasy||Mittelalter', 'https://cf.geekdo-images.com/FMU_f3gwcJ65bIbz0bsY0RIHBaI=/fit-in/246x300/pic2606106.jpg', 'Marcel', 60, 90),
(3201, 'Der Sternen Schild', 2, 6, 3200, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/136986/legends-andor-star-shield', 'Fantasy||Mittelalter', 'https://cf.geekdo-images.com/5WyMEFKl4nUBhdfFnC_4jSqfZeU=/fit-in/246x300/pic2606094.jpg', 'Marcel', 60, 90),
(3202, 'Neue Charaktere', 2, 6, 3200, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/151825/legends-andor-new-heroes', 'Fantasy||Mittelalter', 'https://cf.geekdo-images.com/if2b0UdTev8YZXyEZptY8S9B2Ds=/fit-in/246x300/pic2606095.jpg', 'Marcel', 60, 90),
(3300, 'King of Tokyo', 2, 6, NULL, 'Deutsch', 0, 'https://boardgamegeek.com/boardgame/70323/king-tokyo', 'Fantasy||WÃ¼rfel-Spiel', 'https://cf.geekdo-images.com/wOXROwYuEDNoDY6LhhUPGETrSnM=/fit-in/246x300/pic3043734.jpg', 'Marcel', 30, 45),
(3301, 'Power UP!', 2, 6, 3300, 'Deutsch', 0, 'https://boardgamegeek.com/boardgameexpansion/127067/king-tokyo-power', 'Fantasy||WÃ¼rfel-Spiel', 'https://cf.geekdo-images.com/NnL1h4xgTEAVUkFafMT2vAJO2lU=/fit-in/246x300/pic1449032.jpg', 'Marcel', 30, 45),
(3302, 'Halloween', 2, 6, 3300, 'Deutsch', 0, 'https://boardgamegeek.com/boardgameexpansion/147183/king-tokyo-halloween', 'Fantasy||WÃ¼rfel-Spiel', 'https://cf.geekdo-images.com/8IO4AiyNZ_8OjxhCZIvl_X8pvvc=/fit-in/246x300/pic1867831.jpg', 'Marcel', 30, 45),
(3400, 'Eclipse', 2, 6, NULL, 'Deutsch', 0, 'https://boardgamegeek.com/boardgame/72125/eclipse', 'Weltraum||Miniaturen', 'https://cf.geekdo-images.com/Ng0wVwl4xSa-MeOpuMaq1f7EwDs=/fit-in/246x300/pic1974056.jpg', 'Marcel', 60, 200),
(3401, 'Rise of the Ancients', 2, 6, 3400, 'Deutsch', 0, 'https://boardgamegeek.com/boardgameexpansion/125898/eclipse-rise-ancients', 'Miniaturen', 'https://cf.geekdo-images.com/8FLzk4KjqoX5pNLS4PC3QIIEeX0=/fit-in/246x300/pic1340277.jpg', 'Marcel', 60, 200),
(3500, 'Colt Express', 2, 6, NULL, 'Deutsch', 0, 'https://boardgamegeek.com/boardgame/158899/colt-express', 'Familien-Spiel', 'https://cf.geekdo-images.com/y_EnaXP1QnVRhShv8kWECPrX-hg=/fit-in/246x300/pic2869710.jpg', 'Marcel', 30, 40),
(3600, 'Mysterium', 2, 7, NULL, 'Deutsch', 1, 'https://boardgamegeek.com/boardgame/181304/mysterium', 'Logik', 'https://cf.geekdo-images.com/cmPajGP0Q5NrBkZ7Ur4B7-V677w=/fit-in/246x300/pic2601683.jpg', 'Marcel', 40, 60),
(3601, 'Hidden Signs', 2, 7, 3600, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/192661/mysterium-hidden-signs', 'Logik', 'https://cf.geekdo-images.com/WXMJjjxbHpxbuFt36wiEkip6w9M=/fit-in/246x300/pic3013554.jpg', 'Marcel', 40, 60),
(3700, 'Junta', 2, 7, NULL, 'Deutsch', 0, 'https://boardgamegeek.com/boardgame/242/junta', 'Politik', 'https://cf.geekdo-images.com/RhcOGvSZWfCR0Fxr2-Vmk6YFpJM=/fit-in/246x300/pic2497596.jpg', 'Marcel', 100, 240),
(3800, 'Eldritch Horror', 2, 8, NULL, 'Deutsch', 1, 'https://boardgamegeek.com/boardgame/146021/eldritch-horror', 'Horror||Chutulhu', 'https://cf.geekdo-images.com/I3jxnXvyAIkwvxeayyy4ZjcMdpU=/fit-in/246x300/pic1872452.jpg', 'Marcel', 120, 240),
(3801, 'Berge des Wahnsinns', 2, 8, 3800, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/164167/eldritch-horror-mountains-madness', 'Horror||Chutulhu', 'https://cf.geekdo-images.com/A0sITreDmFcJvti1L6q-84nZP5I=/fit-in/246x300/pic2247632.jpg', 'Marcel', 120, 240),
(3802, 'Absonderliche Ruinen', 2, 8, 3800, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/177182/eldritch-horror-strange-remnants', 'Horror||Chutulhu', 'https://cf.geekdo-images.com/SxPaV62ITjfGd8zoXBnOBS0s5n8=/fit-in/246x300/pic2528391.jpg', 'Marcel', 120, 240),
(3803, 'Vergessenes Wissen', 2, 8, 3800, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/154842/eldritch-horror-forsaken-lore', 'Horror||Chutulhu', 'https://cf.geekdo-images.com/VczHoOJTHGxlr3LXWho5AuBEGbE=/fit-in/246x300/pic1940723.jpg', 'Marcel', 120, 240),
(3900, 'Arkham Horror', 2, 8, NULL, 'Deutsch', 1, 'https://boardgamegeek.com/boardgame/15987/arkham-horror', 'Horror||Chutulhu', 'https://cf.geekdo-images.com/BQgvglr7rfFQLzoF2Wv5LND3XhA=/fit-in/246x300/pic175966.jpg', 'Marcel', 120, 240),
(3901, 'Kingsport Horror', 2, 8, 3900, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/31536/arkham-horror-kingsport-horror-expansion', 'Horror||Chutulhu', 'https://cf.geekdo-images.com/9rZ9lLLDkK7P7sk795eVVmJP5V8=/fit-in/246x300/pic261702.jpg', 'Marcel', 120, 240),
(3902, 'Miskatonic Horror', 2, 8, 3900, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/93465/arkham-horror-miskatonic-horror-expansion', 'Horror||Chutulhu', 'https://cf.geekdo-images.com/RyJCRuO8gshz6cvh809y_92HfK8=/fit-in/246x300/pic929960.jpg', 'Marcel', 120, 240),
(3903, 'Das Grauen von Dunwich', 2, 8, 3900, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/21059/arkham-horror-dunwich-horror-expansion', 'Horror||Chutulhu', 'https://cf.geekdo-images.com/ySLnEQCeoM2ZyYkgTG9txevcf7c=/fit-in/246x300/pic114495.jpg', 'Marcel', 120, 240),
(3904, 'Schatten über Innsmouth', 2, 8, 3900, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/40776/arkham-horror-innsmouth-horror-expansion', 'Horror||Chutulhu', 'https://cf.geekdo-images.com/x9imSPOax7ByxpjSQbi0Yj1ITg4=/fit-in/246x300/pic443909.jpg', 'Marcel', 120, 240),
(3905, 'Der König in Gelb', 2, 8, 3900, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/25945/arkham-horror-king-yellow-expansion', 'Horror||Chutulhu', 'https://cf.geekdo-images.com/y0CecNY9AThS1XpKmzdmCTjGy24=/fit-in/246x300/pic222480.jpg', 'Marcel', 120, 240),
(3906, 'Schwarze Ziege der Wälder', 2, 8, 3900, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/37008/arkham-horror-black-goat-woods-expansion', 'Horror||Chutulhu', 'https://cf.geekdo-images.com/EuLIG9cucuWuHaJ4w7UxNepAoQM=/fit-in/246x300/pic353159.jpg', 'Marcel', 120, 240),
(3907, 'Das Tor des Verderbens', 2, 8, 3900, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/67208/arkham-horror-lurker-threshold-expansion', 'Horror||Chutulhu', 'https://cf.geekdo-images.com/d5xSr1x97fBlIOHd6HttS0KLApM=/fit-in/246x300/pic782540.jpg', 'Marcel', 120, 240),
(3908, 'Der Fluch des schwarzen Pharao', 2, 8, 3900, 'Deutsch', 1, 'https://boardgamegeek.com/boardgameexpansion/22172/arkham-horror-curse-dark-pharaoh-expansion', 'Horror||Chutulhu', 'https://cf.geekdo-images.com/IOSYhtyG77gMgrXyh9JiYn-I7uc=/fit-in/246x300/pic134217.jpg', 'Marcel', 120, 240),
(4000, 'Camel up', 2, 8, NULL, 'Deutsch', 0, 'https://boardgamegeek.com/boardgame/153938/camel', 'Familien-Spiel', 'https://cf.geekdo-images.com/XUqR7TfKt1c5jQ20hL87Coi9DmI=/fit-in/246x300/pic2031446.png', 'Marcel', 20, 30),
(4100, 'Kingsport Festival', 3, 5, NULL, 'Deutsch', 0, 'https://boardgamegeek.com/boardgame/154509/kingsport-festival', 'Horror||Chutulhu', 'https://cf.geekdo-images.com/A3nodsQKyDvlkg4zSCkLTq6-W_s=/fit-in/246x300/pic2073589.jpg', 'Marcel', 90, 120),
(4200, 'Dreams', 3, 6, NULL, 'Deutsch', 4, 'https://boardgamegeek.com/boardgame/205831/dreams', 'Logik', 'https://cf.geekdo-images.com/dibIluRW4j60a74mbOfhx9vV-AQ=/fit-in/246x300/pic3126014.jpg', 'Marcel', 30, 45),
(4300, 'Winter Tales', 3, 7, NULL, 'Deutsch', 4, 'https://boardgamegeek.com/boardgame/122599/winter-tales', 'Story-Telling', 'https://cf.geekdo-images.com/0p3U2B1YvgAYCttX8ild3p1bTu8=/fit-in/246x300/pic1736360.jpg', 'Marcel', 90, 120),
(4400, 'Panic Station', 4, 6, NULL, 'Deutsch', 3, 'https://boardgamegeek.com/boardgame/69552/panic-station', 'Weltraum||Horror', 'https://cf.geekdo-images.com/4y5254QLf6L383rrJmo_D1rMiqo=/fit-in/246x300/pic1086190.jpg', 'Marcel', 40, 60),
(4500, 'Cash & Guns', 4, 8, NULL, 'Deutsch', 0, 'https://boardgamegeek.com/boardgame/155362/cah-n-guns-second-edition', 'Familien-Spiel', 'https://cf.geekdo-images.com/7dpJ9QM2tTkV7uhk5BsFzx9eETU=/fit-in/246x300/pic2907864.jpg', 'Marcel', 30, 45),
(4600, 'Concept', 4, 12, NULL, 'Deutsch', 4, 'https://boardgamegeek.com/boardgame/147151/concept', 'Familien-Spiel||Logik', 'https://cf.geekdo-images.com/wM-IUIp21wMcsBtdiMLxvouL4pI=/fit-in/246x300/pic1907628.jpg', 'Marcel', 40, 45),
(4700, 'Kingdom Death: Monster', 1, 6, NULL, 'Englisch', 1, 'https://www.boardgamegeek.com/boardgame/55690/kingdom-death-monster', 'Horror||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/IkVVF7oLMQOwbcyQdtF52dNg8nI=/fit-in/246x300/pic2931007.jpg', 'Marcel', 60, 120),
(4701, 'Dragon King', 1, 6, 4700, 'Deutsch', 1, 'https://www.boardgamegeek.com/boardgameexpansion/135034/kingdom-death-monster-dragon-king-expansion', 'Horror||Dungeon||Miniaturen||Story-Telling', 'https://cf.geekdo-images.com/sjBkJ11y544tym0j1ZJS5UxSkbU=/fit-in/246x300/pic2933144.jpg', 'Marcel', 60, 12),
(4702, 'Gorm', 1, 6, 4700, 'Deutsch', 1, 'https://www.boardgamegeek.com/boardgameexpansion/135036/kingdom-death-monster-gorm-expansion', 'Horror||Dungeon||Miniaturen||Story-Telling', 'https://cf.geekdo-images.com/LkP1wnkh0g7cTxShUA0a1wAHhHU=/fit-in/246x300/pic2933166.jpg', 'Marcel', 60, 12),
(4703, 'Sun Stalker', 1, 6, 4700, 'Englisch', 1, 'https://www.boardgamegeek.com/boardgameexpansion/135523/kingdom-death-monster-sunstalker-expansion', '', 'https://cf.geekdo-images.com/tx0N5zaAQ5e2MCFmQuqVOZZFd4o=/fit-in/246x300/pic2933185.jpg', 'Marcel', 60, 12),
(4704, 'Spidicules', 1, 6, 4700, 'Englisch', 1, 'https://www.boardgamegeek.com/boardgameexpansion/135273/kingdom-death-monster-spidicules-expansion', '', 'https://cf.geekdo-images.com/b2EDhFJbJ3G30BffQPW0glx2DbE=/fit-in/246x300/pic2933184.jpg', 'Marcel', 60, 12),
(4705, 'Dung Beetle Knight', 1, 6, 4700, 'Englisch', 1, 'https://www.boardgamegeek.com/boardgameexpansion/135179/kingdom-death-monster-dung-beetle-knight-expansion', '', 'https://cf.geekdo-images.com/ZZWK7G7knK3sz3WNul_myJ7OO40=/fit-in/246x300/pic2933155.jpg', 'Marcel', 60, 12),
(4706, 'Flower Knight', 1, 6, 4700, 'Englisch', 1, 'https://www.boardgamegeek.com/boardgameexpansion/135030/kingdom-death-monster-flower-knight-expansion', '', 'https://cf.geekdo-images.com/kOy3r13stdkF5Fawps8wAyPhDJo=/fit-in/246x300/pic2933160.jpg', 'Marcel', 60, 12),
(4707, 'Lonely Tree', 1, 6, 4700, 'Englisch', 1, 'https://www.boardgamegeek.com/boardgameexpansion/136135/kingdom-death-monster-lonely-tree-expansion', '', 'https://cf.geekdo-images.com/-lT7gjRMKW5huEbGEZcEo68dCsI=/fit-in/246x300/pic2933171.jpg', 'Marcel', 60, 12),
(4708, 'Slenderman', 1, 6, 4700, 'Englisch', 1, 'https://www.boardgamegeek.com/boardgameexpansion/136137/kingdom-death-monster-slenderman-expansion', 'Horror', 'https://cf.geekdo-images.com/v25WQQJf8o0cSOACRGQFon97-C4=/fit-in/246x300/pic2933180.jpg', 'Marcel', 60, 12),
(4709, 'Lion Knight', 1, 6, 4700, 'Englisch', 1, 'https://www.boardgamegeek.com/boardgameexpansion/135037/kingdom-death-monster-lion-knight-expansion', 'Horror', 'https://cf.geekdo-images.com/zFsCia0cjG6BOrYEf44hj4IJb-4=/fit-in/246x300/pic2933170.jpg', 'Marcel', 60, 12),
(4710, 'Lion God', 1, 6, 4700, 'Englisch', 1, 'https://www.boardgamegeek.com/boardgameexpansion/135712/kingdom-death-monster-lion-god-expansion', 'Horror', 'https://cf.geekdo-images.com/6n7IKsmWmOlof63w_UugkwW24DQ=/fit-in/246x300/pic2933169.jpg', 'Marcel', 60, 12),
(4711, 'Man Hunter', 1, 6, 4700, 'Englisch', 1, 'https://www.boardgamegeek.com/boardgameexpansion/135035/kingdom-death-monster-manhunter-expansion', 'Horror', 'https://cf.geekdo-images.com/4k87jndbG8n-CEBEE1UQuF2WbQY=/fit-in/246x300/pic2933173.jpg', 'Marcel', 60, 12),
(4712, 'Green Knight Armor', 1, 6, 4700, 'Englisch', 1, 'https://www.boardgamegeek.com/boardgameexpansion/195317/kingdom-death-monster-green-knight-armor-expansion', 'Horror', 'https://cf.geekdo-images.com/dipeUnMQjONM7btTsp853JorOmQ=/fit-in/246x300/pic3018564.jpg', 'Marcel', 60, 12),
(4800, 'BAM!', 4, 10, NULL, 'Deutsch', 0, 'https://www.boardgamegeek.com/boardgame/146496/bam-das-unanstandig-gute-wortspiel', 'Familien-Spiel||Karten-Spiel', 'https://cf.geekdo-images.com/HPV2_37H2ti0TuL0RTXvr-G7XmM=/fit-in/246x300/pic1772038.jpg', 'Marcel', 20, 40),
(4801, 'Extrahart', 4, 10, 4800, 'Deutsch', 0, 'https://www.boardgamegeek.com/boardgame/181906/bam-extrahart', 'Familien-Spiel||Karten-Spiel', 'https://cf.geekdo-images.com/21dtwqVxjivPgUUMCM6THZlyOXk=/fit-in/246x300/pic2635796.jpg', 'Marcel', 20, 40),
(4900, 'Talisman', 2, 6, NULL, 'Deutsch', 0, 'https://boardgamegeek.com/boardgame/27627/talisman-revised-4th-edition', 'Fantasy||Mittelalter||WÃ¼rfel-Spiel||Miniaturen', 'https://cf.geekdo-images.com/jXLyHHlBwJZmO0uGM4QCTH73q6U=/fit-in/246x300/pic332870.jpg', 'Pat', 90, 240),
(4901, 'Talsiman: Das Waldland', 2, 6, 4900, 'Deutsch', 0, 'https://boardgamegeek.com/boardgameexpansion/158979/talisman-revised-4th-edition-woodland-expansion', 'Fantasy||Mittelalter||WÃ¼rfel-Spiel', 'https://cf.geekdo-images.com/7DrwiMpVQl8vyFybr-g2dFfvXGE=/fit-in/246x300/pic2079270.jpg', 'Pat', 90, 240),
(4902, 'Talisman: Die Stadt', 2, 6, 4900, 'Deutsch', 0, 'https://boardgamegeek.com/boardgameexpansion/131816/talisman-revised-4th-edition-city-expansion', 'Fantasy||Mittelalter||WÃ¼rfel-Spiel', 'https://cf.geekdo-images.com/ehpje3FwImFlcwbhJRmpmrhoGBQ=/fit-in/246x300/pic1442153.jpg', 'Pat', 90, 240),
(4903, 'Talisman: Die Katakomben', 2, 6, 4900, 'Deutsch', 0, 'https://boardgamegeek.com/boardgameexpansion/41064/talisman-revised-4th-edition-dungeon-expansion', 'Fantasy||Mittelalter||WÃ¼rfel-Spiel', 'https://cf.geekdo-images.com/qxHHa9mSkVhiDvwZyJuzaznER70=/fit-in/246x300/pic447495.jpg', 'Pat', 90, 240),
(4904, 'Talisman: Das Hochland', 2, 6, 4900, 'Deutsch', 0, 'https://boardgamegeek.com/boardgameexpansion/67051/talisman-revised-4th-edition-highland-expansion', 'Fantasy||Mittelalter||WÃ¼rfel-Spiel', 'https://cf.geekdo-images.com/sLNR0iwlodkc7wtMd0JkhUgA-k0=/fit-in/246x300/pic667546.jpg', 'Pat', 90, 240),
(4905, 'Talisman: Der Schnitter', 2, 6, 4900, 'Deutsch', 0, 'https://boardgamegeek.com/boardgameexpansion/38025/talisman-revised-4th-edition-reaper-expansion', 'Fantasy||Mittelalter||WÃ¼rfel-Spiel', 'https://cf.geekdo-images.com/BizZvegZQiSNDxM_b7qUH0y4g-c=/fit-in/246x300/pic365158.jpg', 'Pat', 90, 240),
(4906, 'Talisman: Die Frostmark', 2, 6, 4900, 'Deutsch', 0, 'https://boardgamegeek.com/boardgameexpansion/54475/talisman-revised-4th-edition-frostmarch-expansion', 'Fantasy||Mittelalter||WÃ¼rfel-Spiel', 'https://cf.geekdo-images.com/hINkJ_eMAsg1aWb8kD115ORBG7A=/fit-in/246x300/pic544607.jpg', 'Pat', 90, 240),
(4907, 'Talisman: Der Blutmond', 2, 6, 4900, 'Deutsch', 0, 'https://boardgamegeek.com/boardgameexpansion/121786/talisman-revised-4th-edition-blood-moon-expansion', 'Fantasy||Mittelalter||WÃ¼rfel-Spiel', 'https://cf.geekdo-images.com/aZ5Ogml07VBQs6qrvLngrWlrlQg=/fit-in/246x300/pic1254551.jpg', 'Pat', 90, 240),
(5000, 'Die Zwerge', 2, 5, NULL, 'Deutsch', 1, 'https://www.boardgamegeek.com/boardgame/124668/dwarves', 'Fantasy||Mittelalter||WÃ¼rfel-Spiel||Miniaturen', 'https://cf.geekdo-images.com/fdjJqrzPnhb7_Uzv_5LLwmbJTfo=/fit-in/246x300/pic2526430.jpg', 'Pat', 60, 90),
(5001, 'Die Zwege: Charakter-Erweiterung', 2, 5, 5000, 'Deutsch', 0, 'https://www.boardgamegeek.com/boardgameexpansion/207320/dwarves-new-heroes-expansion', 'Fantasy||Mittelalter||WÃ¼rfel-Spiel||Miniaturen', 'https://cf.geekdo-images.com/53EHRxdJUiyt2ua-6A_676A0EyM=/fit-in/246x300/pic3147719.jpg', 'Pat', 60, 90),
(5100, 'Dungeons & Dragons: Wrath of Ashardalon', 1, 5, NULL, 'Englisch', 1, 'https://www.boardgamegeek.com/boardgame/66356/dungeons-dragons-wrath-ashardalon-board-game', 'Fantasy||Mittelalter||WÃ¼rfel-Spiel||Dungeon||Miniaturen||Story-Telling', 'https://cf.geekdo-images.com/GC37-8oNU7itBXOR0SdIDSi-4tU=/fit-in/246x300/pic968280.jpg', 'Pat', 45, 180),
(5200, ' Dungeons & Dragons: The Legend of Drizzt', 1, 5, NULL, 'Englisch', 1, 'https://www.boardgamegeek.com/boardgame/91872/dungeons-dragons-legend-drizzt-board-game', 'Fantasy||Mittelalter||WÃ¼rfel-Spiel||Dungeon||Miniaturen||Story-Telling', 'https://cf.geekdo-images.com/qn3XsQgF7cZuGZqsbZkoKQqLkI4=/fit-in/246x300/pic994268.jpg', 'Pat', 45, 180),
(5300, 'Dungeons & Dragons: Das Fantasy Abenteuerspiel', 2, 5, NULL, 'Deutsch', 2, 'https://www.boardgamegeek.com/boardgame/6366/dungeons-dragons-fantasy-adventure-board-game', 'Fantasy||Mittelalter||WÃ¼rfel-Spiel||Dungeon||Miniaturen||Story-Telling', 'https://cf.geekdo-images.com/88DZ1UGFNFbsojoa5G6eHXX23u0=/fit-in/246x300/pic681985.jpg', 'Pat', 60, 120),
(5400, 'Magic. The Gathering - Arena of the Planeswalkers', 2, 5, NULL, 'Deutsch', 4, 'https://www.boardgamegeek.com/boardgame/167698/magic-gathering-arena-planeswalkers', 'Fantasy||Miniaturen', 'https://cf.geekdo-images.com/VQjQl3l_6KBDT_QoXSNkKmPxLGI=/fit-in/246x300/pic2411639.jpg', 'Pat', 60, 120),
(5500, 'DungeonQuest', 1, 4, NULL, 'Deutsch', 0, 'https://boardgamegeek.com/boardgame/157958/dungeonquest-revised-edition', 'Fantasy||Mittelalter||WÃ¼rfel-Spiel||Dungeon||Miniaturen', 'https://cf.geekdo-images.com/1mnxCsWD_fLGQn0Dmh03nfmh874=/fit-in/246x300/pic2017396.jpg', 'Pat', 30, 90),
(5600, 'Exploding Kittens', 2, 5, NULL, 'Deutsch', 0, 'https://www.boardgamegeek.com/boardgame/172225/exploding-kittens', 'Karten-Spiel', 'https://cf.geekdo-images.com/W6Stka2LUIxTWXMscoTqKqNosAY=/fit-in/246x300/pic2691976.png', 'Pat', 15, 30),
(5700, 'Exploding Kittens: NSFW Deck', 2, 5, NULL, 'Deutsch', 0, 'https://www.boardgamegeek.com/boardgame/172242/exploding-kittens-nsfw-deck', 'Karten-Spiel', 'https://cf.geekdo-images.com/OmGTrgAmN3feP7MFqJ4VFuTPY48=/fit-in/246x300/pic2815278.jpg', 'Pat', 15, 30);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `brettspiele`
--
ALTER TABLE `brettspiele`
 ADD PRIMARY KEY (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
