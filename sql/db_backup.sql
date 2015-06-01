--
-- Database: 'agiletr1_mhmaphelper'
--

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
-- Table structure for table 'locations'
--

DROP TABLE IF EXISTS locations;
CREATE TABLE IF NOT EXISTS locations (
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
-- Table structure for table 'mice_cheeses'
--

DROP TABLE IF EXISTS mice_cheeses;
CREATE TABLE IF NOT EXISTS mice_cheeses (
  mice_id int(10) unsigned NOT NULL,
  cheeses_id int(10) unsigned NOT NULL,
  PRIMARY KEY (mice_id,cheeses_id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table 'mice_locations'
--

DROP TABLE IF EXISTS mice_locations;
CREATE TABLE IF NOT EXISTS mice_locations (
  mice_id int(10) unsigned NOT NULL,
  locations_id int(10) unsigned NOT NULL,
  PRIMARY KEY (mice_id,locations_id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
