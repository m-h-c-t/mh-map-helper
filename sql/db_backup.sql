--
-- Database: 'agiletr1_mhmaphelper'
--

-- --------------------------------------------------------

--
-- Table structure for table 'areas'
--

DROP TABLE IF EXISTS areas;
CREATE TABLE IF NOT EXISTS areas (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table 'cheeses'
--

DROP TABLE IF EXISTS cheeses;
CREATE TABLE IF NOT EXISTS cheeses (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table 'mice'
--

DROP TABLE IF EXISTS mice;
CREATE TABLE IF NOT EXISTS mice (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table 'mice_areas'
--

DROP TABLE IF EXISTS mice_areas;
CREATE TABLE IF NOT EXISTS mice_areas (
  mice_id int(10) unsigned NOT NULL,
  areas_id int(10) unsigned NOT NULL,
  PRIMARY KEY (mice_id,areas_id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table 'mice_cheeses'
--

DROP TABLE IF EXISTS mice_cheeses;
CREATE TABLE IF NOT EXISTS mice_cheeses (
  mice_id int(10) unsigned NOT NULL,
  cheeses_id int(10) unsigned NOT NULL,
  PRIMARY KEY (mice_id,cheeses_id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
