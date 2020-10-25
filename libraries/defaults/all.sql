-- Table structure for table 'phpads_userlog'


CREATE TABLE phpads_userlog (
    userlogid MEDIUMINT(9)             NOT NULL AUTO_INCREMENT,
    timestamp INT(11)      DEFAULT '0' NOT NULL,
    usertype  TINYINT(4)   DEFAULT '0' NOT NULL,
    userid    MEDIUMINT(9) DEFAULT '0' NOT NULL,
    action    MEDIUMINT(9) DEFAULT '0' NOT NULL,
    object    MEDIUMINT(9),
    details   BLOB,
    PRIMARY KEY (userlogid)
);


-- Table structure for table 'phpads_affiliates'


CREATE TABLE phpads_affiliates (
    affiliateid MEDIUMINT(9)               NOT NULL AUTO_INCREMENT,
    name        VARCHAR(255)               NOT NULL,
    contact     VARCHAR(255),
    email       VARCHAR(64)                NOT NULL,
    website     VARCHAR(255),
    username    VARCHAR(64),
    password    VARCHAR(64),
    permissions MEDIUMINT(9),
    language    VARCHAR(64),
    publiczones ENUM ('t','f') DEFAULT 'f' NOT NULL,
    PRIMARY KEY (affiliateid)
);


-- Table structure for table 'phpads_cache'


CREATE TABLE phpads_cache (
    cacheid VARCHAR(255) NOT NULL,
    content BLOB         NOT NULL,
    PRIMARY KEY (cacheid)
);


-- Table structure for table 'phpads_zones'


CREATE TABLE phpads_zones (
    zoneid      MEDIUMINT(9)            NOT NULL AUTO_INCREMENT,
    affiliateid MEDIUMINT(9),
    zonename    VARCHAR(245)            NOT NULL,
    description VARCHAR(255)            NOT NULL,
    delivery    SMALLINT(6) DEFAULT '0' NOT NULL,
    zonetype    SMALLINT(6) DEFAULT '0' NOT NULL,
    what        BLOB                    NOT NULL,
    width       SMALLINT(6) DEFAULT '0' NOT NULL,
    height      SMALLINT(6) DEFAULT '0' NOT NULL,
    chain       BLOB                    NOT NULL,
    prepend     BLOB                    NOT NULL,
    append      BLOB                    NOT NULL,
    appendtype  TINYINT(4)  DEFAULT '0' NOT NULL,
    PRIMARY KEY (zoneid),
    KEY zonenameid (zonename, zoneid)
);


-- Table structure for table 'phpads_adclicks'


CREATE TABLE phpads_adclicks (
    bannerid MEDIUMINT(9) DEFAULT '0' NOT NULL,
    zoneid   MEDIUMINT(9) DEFAULT '0' NOT NULL,
    t_stamp  TIMESTAMP(14),
    host     VARCHAR(255)             NOT NULL,
    source   VARCHAR(50)              NOT NULL,
    country  CHAR(2)                  NOT NULL,
    KEY bannerid_date (bannerid, t_stamp),
    KEY date (t_stamp)
);


-- Table structure for table 'phpads_adviews'


CREATE TABLE phpads_adviews (
    bannerid MEDIUMINT(9) DEFAULT '0' NOT NULL,
    zoneid   MEDIUMINT(9) DEFAULT '0' NOT NULL,
    t_stamp  TIMESTAMP(14),
    host     VARCHAR(255)             NOT NULL,
    source   VARCHAR(50)              NOT NULL,
    country  CHAR(2)                  NOT NULL,
    KEY bannerid_date (bannerid, t_stamp),
    KEY date (t_stamp)
);


-- Table structure for table 'phpads_images'


CREATE TABLE phpads_images (
    filename VARCHAR(128) NOT NULL,
    contents MEDIUMBLOB   NOT NULL,
    t_stamp  TIMESTAMP(14),
    PRIMARY KEY (filename)
);


-- Table structure for table 'phpads_banners'


CREATE TABLE phpads_banners (
    bannerid           MEDIUMINT(9)                                                                 NOT NULL AUTO_INCREMENT,
    clientid           MEDIUMINT(9)                                                   DEFAULT '0'   NOT NULL,
    active             ENUM ('t','f')                                                 DEFAULT 't'   NOT NULL,
    priority           INT(11)                                                        DEFAULT '0'   NOT NULL,
    contenttype        ENUM ('gif','jpeg','png','html','swf','dcr','rpm','mov','txt') DEFAULT 'gif' NOT NULL,
    pluginversion      MEDIUMINT(9)                                                   DEFAULT '0'   NOT NULL,
    storagetype        ENUM ('sql','web','url','html','network','txt')                DEFAULT 'sql' NOT NULL,
    filename           VARCHAR(255)                                                                 NOT NULL,
    imageurl           VARCHAR(255)                                                                 NOT NULL,
    htmltemplate       BLOB                                                                         NOT NULL,
    htmlcache          BLOB                                                                         NOT NULL,
    width              SMALLINT(6)                                                    DEFAULT '0'   NOT NULL,
    height             SMALLINT(6)                                                    DEFAULT '0'   NOT NULL,
    weight             TINYINT(4)                                                     DEFAULT '1'   NOT NULL,
    seq                TINYINT(4)                                                     DEFAULT '0'   NOT NULL,
    target             VARCHAR(16)                                                                  NOT NULL,
    url                VARCHAR(255)                                                                 NOT NULL,
    alt                VARCHAR(255)                                                                 NOT NULL,
    status             VARCHAR(255)                                                                 NOT NULL,
    keyword            VARCHAR(255)                                                                 NOT NULL,
    bannertext         BLOB                                                                         NOT NULL,
    description        VARCHAR(255)                                                                 NOT NULL,
    autohtml           ENUM ('t','f')                                                 DEFAULT 't'   NOT NULL,
    block              INT(11)                                                        DEFAULT '0'   NOT NULL,
    capping            INT(11)                                                        DEFAULT '0'   NOT NULL,
    compiledlimitation BLOB                                                                         NOT NULL,
    append             BLOB                                                                         NOT NULL,
    appendtype         TINYINT(4)                                                     DEFAULT '0'   NOT NULL,
    bannertype         TINYINT(4)                                                     DEFAULT '0'   NOT NULL,
    PRIMARY KEY (bannerid)
);


-- Table structure for table 'phpads_clients'


CREATE TABLE phpads_clients (
    clientid         MEDIUMINT(9)                        NOT NULL AUTO_INCREMENT,
    clientname       VARCHAR(255)                        NOT NULL,
    contact          VARCHAR(255),
    email            VARCHAR(64)                         NOT NULL,
    views            INT(11),
    clicks           INT(11),
    clientusername   VARCHAR(64)                         NOT NULL,
    clientpassword   VARCHAR(64)                         NOT NULL,
    expire           DATE           DEFAULT '0000-00-00',
    activate         DATE           DEFAULT '0000-00-00',
    permissions      MEDIUMINT(9),
    language         VARCHAR(64),
    active           ENUM ('t','f') DEFAULT 't'          NOT NULL,
    weight           TINYINT(4)     DEFAULT '1'          NOT NULL,
    target           INT(11)        DEFAULT '0'          NOT NULL,
    parent           MEDIUMINT(9)   DEFAULT '0'          NOT NULL,
    report           ENUM ('t','f') DEFAULT 't'          NOT NULL,
    reportinterval   MEDIUMINT(9)   DEFAULT '7'          NOT NULL,
    reportlastdate   DATE           DEFAULT '0000-00-00' NOT NULL,
    reportdeactivate ENUM ('t','f') DEFAULT 't'          NOT NULL,
    PRIMARY KEY (clientid)
);


-- Table structure for table 'phpads_session'


CREATE TABLE phpads_session (
    sessionid   VARCHAR(32) NOT NULL,
    sessiondata BLOB        NOT NULL,
    lastused    TIMESTAMP(14),
    PRIMARY KEY (sessionid)
);


-- Table structure for table 'phpads_acls'

CREATE TABLE phpads_acls (
    bannerid       MEDIUMINT(9)     DEFAULT '0'  NOT NULL,
    logical        SET ('and','or')              NOT NULL,
    type           VARCHAR(16)                   NOT NULL,
    comparison     CHAR(2)          DEFAULT '==' NOT NULL,
    data           TEXT                          NOT NULL,
    executionorder INT(10) UNSIGNED DEFAULT '0'  NOT NULL,
    KEY bannerid (bannerid),
    UNIQUE bannerid_executionorder (bannerid, executionorder)
);


-- Table structure for table 'phpads_adstats'


CREATE TABLE phpads_adstats (
    views    INT(11)     DEFAULT '0'          NOT NULL,
    clicks   INT(11)     DEFAULT '0'          NOT NULL,
    day      DATE        DEFAULT '0000-00-00' NOT NULL,
    hour     TINYINT(4)  DEFAULT '0'          NOT NULL,
    bannerid SMALLINT(6) DEFAULT '0'          NOT NULL,
    zoneid   SMALLINT(6) DEFAULT '0'          NOT NULL,
    source   VARCHAR(50)                      NOT NULL,
    PRIMARY KEY (day, hour, bannerid, zoneid, source),
    KEY bannerid_day (bannerid, day)
);


-- Table structure for table 'phpads_targetstats'

CREATE TABLE phpads_targetstats (
    day      DATE        DEFAULT '0000-00-00' NOT NULL,
    clientid SMALLINT(6) DEFAULT '0'          NOT NULL,
    target   INT(11)     DEFAULT '0'          NOT NULL,
    views    INT(11)     DEFAULT '0'          NOT NULL,
    modified TINYINT(4)  DEFAULT '0'          NOT NULL,
    PRIMARY KEY (day, clientid)
);


-- Table structure for table 'phpads_config'


CREATE TABLE phpads_config (
    configid                      TINYINT(2)     DEFAULT '0'              NOT NULL,
    config_version                DECIMAL(7, 3)  DEFAULT '0.000'          NOT NULL,
    table_border_color            VARCHAR(7)     DEFAULT '#000099'        NOT NULL,
    table_back_color              VARCHAR(7)     DEFAULT '#CCCCCC'        NOT NULL,
    table_back_color_alternative  VARCHAR(7)     DEFAULT '#F7F7F7'        NOT NULL,
    main_back_color               VARCHAR(7)     DEFAULT '#FFFFFF'        NOT NULL,
    my_header                     VARCHAR(255)   DEFAULT ''               NOT NULL,
    my_footer                     VARCHAR(255)   DEFAULT ''               NOT NULL,
    language                      VARCHAR(32)    DEFAULT 'english'        NOT NULL,
    name                          VARCHAR(32)    DEFAULT ''               NOT NULL,
    company_name                  VARCHAR(255)   DEFAULT 'mysite.com'     NOT NULL,
    override_gd_imageformat       VARCHAR(4)     DEFAULT ''               NOT NULL,
    begin_of_week                 TINYINT(2)     DEFAULT '1'              NOT NULL,
    percentage_decimals           TINYINT(2)     DEFAULT '2'              NOT NULL,
    type_sql_allow                ENUM ('t','f') DEFAULT 't'              NOT NULL,
    type_url_allow                ENUM ('t','f') DEFAULT 't'              NOT NULL,
    type_web_allow                ENUM ('t','f') DEFAULT 'f'              NOT NULL,
    type_html_allow               ENUM ('t','f') DEFAULT 't'              NOT NULL,
    type_txt_allow                ENUM ('t','f') DEFAULT 't'              NOT NULL,
    type_web_mode                 TINYINT(2)     DEFAULT '0'              NOT NULL,
    type_web_dir                  VARCHAR(255)   DEFAULT ''               NOT NULL,
    type_web_ftp                  VARCHAR(255)   DEFAULT ''               NOT NULL,
    type_web_url                  VARCHAR(255)   DEFAULT ''               NOT NULL,
    admin                         VARCHAR(64)    DEFAULT 'phpadsuser'     NOT NULL,
    admin_pw                      VARCHAR(64)    DEFAULT 'phpadspass'     NOT NULL,
    admin_fullname                VARCHAR(255)   DEFAULT 'Your Name'      NOT NULL,
    admin_email                   VARCHAR(64)    DEFAULT 'your@email.com' NOT NULL,
    admin_email_headers           VARCHAR(64)    DEFAULT ''               NOT NULL,
    admin_novice                  ENUM ('t','f') DEFAULT 't'              NOT NULL,
    default_banner_weight         TINYINT(4)     DEFAULT '1'              NOT NULL,
    default_campaign_weight       TINYINT(4)     DEFAULT '1'              NOT NULL,
    client_welcome                ENUM ('t','f') DEFAULT 't'              NOT NULL,
    client_welcome_msg            TEXT           DEFAULT ''               NOT NULL,
    content_gzip_compression      ENUM ('t','f') DEFAULT 'f'              NOT NULL,
    userlog_email                 ENUM ('t','f') DEFAULT 't'              NOT NULL,
    userlog_priority              ENUM ('t','f') DEFAULT 't'              NOT NULL,
    userlog_autoclean             ENUM ('t','f') DEFAULT 't'              NOT NULL,
    gui_show_campaign_info        ENUM ('t','f') DEFAULT 't'              NOT NULL,
    gui_show_campaign_preview     ENUM ('t','f') DEFAULT 'f'              NOT NULL,
    gui_show_banner_info          ENUM ('t','f') DEFAULT 't'              NOT NULL,
    gui_show_banner_preview       ENUM ('t','f') DEFAULT 't'              NOT NULL,
    gui_show_banner_html          ENUM ('t','f') DEFAULT 'f'              NOT NULL,
    gui_show_matching             ENUM ('t','f') DEFAULT 't'              NOT NULL,
    gui_show_parents              ENUM ('t','f') DEFAULT 'f'              NOT NULL,
    gui_hide_inactive             ENUM ('t','f') DEFAULT 'f'              NOT NULL,
    gui_link_compact_limit        TINYINT(2)     DEFAULT '50'             NOT NULL,
    qmail_patch                   ENUM ('t','f') DEFAULT 'f'              NOT NULL,
    updates_frequency             TINYINT(2)     DEFAULT '7'              NOT NULL,
    updates_timestamp             INT(11)        DEFAULT '0'              NOT NULL,
    updates_last_seen             DECIMAL(7, 3)  DEFAULT '0.000'          NOT NULL,
    allow_invocation_plain        ENUM ('t','f') DEFAULT 'f'              NOT NULL,
    allow_invocation_js           ENUM ('t','f') DEFAULT 't'              NOT NULL,
    allow_invocation_frame        ENUM ('t','f') DEFAULT 'f'              NOT NULL,
    allow_invocation_xmlrpc       ENUM ('t','f') DEFAULT 'f'              NOT NULL,
    allow_invocation_local        ENUM ('t','f') DEFAULT 't'              NOT NULL,
    allow_invocation_interstitial ENUM ('t','f') DEFAULT 't'              NOT NULL,
    allow_invocation_popup        ENUM ('t','f') DEFAULT 't'              NOT NULL,
    auto_clean_tables             ENUM ('t','f') DEFAULT 'f'              NOT NULL,
    auto_clean_tables_interval    TINYINT(2)     DEFAULT '5'              NOT NULL,
    auto_clean_userlog            ENUM ('t','f') DEFAULT 'f'              NOT NULL,
    auto_clean_userlog_interval   TINYINT(2)     DEFAULT '5'              NOT NULL,
    auto_clean_tables_vacuum      ENUM ('t','f') DEFAULT 't'              NOT NULL,
    autotarget_factor             FLOAT          DEFAULT '-1'             NOT NULL,
    maintenance_timestamp         INT(11)        DEFAULT '0'              NOT NULL,
    PRIMARY KEY (configid)
);

