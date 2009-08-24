-- 
-- SQL for DataCenter Extension
-- 
-- Facilities
-- 
-- Table of locations of physical datacenters
DROP TABLE IF EXISTS /*$wgDBprefix*/dc_facility_locations;
CREATE TABLE /*$wgDBprefix*/dc_facility_locations (
    -- Unique ID of dc_locations
    fcl_loc_id INTEGER AUTO_INCREMENT,
    -- Tense of this rack
    fcl_loc_tense ENUM( 'past', 'present', 'future' ) default 'present',
    -- Name of this location
    fcl_loc_name VARBINARY(255) NOT NULL default '',
    -- Region of this location
    fcl_loc_region VARBINARY(255) NOT NULL default '',
    -- Latitude value of this location
    fcl_loc_latitude FLOAT(12,8),
    -- Longitude value of this location
    fcl_loc_longitude FLOAT(12,8),
    -- 
    PRIMARY KEY (fcl_loc_id)
) /*$wgDBTableOptions*/;
-- 
-- Table of spaces in locations
DROP TABLE IF EXISTS /*$wgDBprefix*/dc_facility_spaces;
CREATE TABLE /*$wgDBprefix*/dc_facility_spaces (
    -- Unique ID of dc_spaces
    fcl_spc_id INTEGER AUTO_INCREMENT,
    -- Tense of this rack
    fcl_spc_tense ENUM( 'past', 'present', 'future' ) default 'present',
    -- Name of this space
    fcl_spc_name VARBINARY(255) NOT NULL default '',
    -- ID of location this space is in
    fcl_spc_location INTEGER,
    -- Width of this space in meters
    fcl_spc_width INTEGER,
    -- Height of this space in meters
    fcl_spc_height INTEGER,
    -- Depth of this space in meters
    fcl_spc_depth INTEGER,
    -- Power capacity in watts
    fcl_spc_power INTEGER,
    -- 
    PRIMARY KEY (fcl_spc_id)
) /*$wgDBTableOptions*/;
-- 
-- Assets
-- 
-- Table of racks
DROP TABLE IF EXISTS /*$wgDBprefix*/dc_rack_assets;
CREATE TABLE /*$wgDBprefix*/dc_rack_assets (
    -- Unique ID of dc_racks
    ast_rak_id INTEGER AUTO_INCREMENT,
    -- Tense of this racj
    ast_rak_tense ENUM( 'past', 'present', 'future' ) default 'present',
    -- ID of location this space is in
    ast_rak_location INTEGER,
    -- ID of model this rack is
    ast_rak_model INTEGER,
    -- Serial Number of rack
    ast_rak_serial VARBINARY(255) NOT NULL default '',
    -- Asset Number of rack
    ast_rak_asset VARBINARY(255) NOT NULL default '',
    -- 
    PRIMARY KEY (ast_rak_id)
) /*$wgDBTableOptions*/;
-- 
-- Table of objects
DROP TABLE IF EXISTS /*$wgDBprefix*/dc_object_assets;
CREATE TABLE /*$wgDBprefix*/dc_object_assets (
    -- Unique ID of dc_objects
    ast_obj_id INTEGER AUTO_INCREMENT,
    -- Tense of this rack
    ast_obj_tense ENUM( 'past', 'present', 'future' ) default 'present',
    -- ID of location this space is in
    ast_obj_location INTEGER,
    -- ID of model this object is of
    ast_obj_model INTEGER,
    -- Serial Number of object
    ast_obj_serial VARBINARY(255) NOT NULL default '',
    -- Asset Number of object
    ast_obj_asset VARBINARY(255) NOT NULL default '',
    -- 
    PRIMARY KEY (ast_obj_id)
) /*$wgDBTableOptions*/;
-- 
-- Models
-- 
-- Table of model of racks
DROP TABLE IF EXISTS /*$wgDBprefix*/dc_rack_models;
CREATE TABLE /*$wgDBprefix*/dc_rack_models (
    -- Unique ID of dc_rack_models
    mdl_rak_id INTEGER AUTO_INCREMENT,
    -- Manufacturer name of this rack model
    mdl_rak_manufacturer VARBINARY(255) NOT NULL default '',
    -- Model name of this rack model
    mdl_rak_name VARBINARY(255) NOT NULL default '',
    -- Kind of this rack model
    mdl_rak_kind VARBINARY(255) NOT NULL default '',
    -- Number of vertical rack units this rack model can hold
    mdl_rak_units INTEGER,
    -- 
    PRIMARY KEY (mdl_rak_id)
) /*$wgDBTableOptions*/;
-- 
-- Table of model of objects
DROP TABLE IF EXISTS /*$wgDBprefix*/dc_object_models;
CREATE TABLE /*$wgDBprefix*/dc_object_models (
    -- Unique ID of dc_object_models
    mdl_obj_id INTEGER AUTO_INCREMENT,
    -- Manufacturer name of this object model
    mdl_obj_manufacturer VARBINARY(255) NOT NULL default '',
    -- Model name of this object model
    mdl_obj_name VARBINARY(255) NOT NULL default '',
    -- Kind of this object model
    mdl_obj_kind VARBINARY(255) NOT NULL default '',
    -- The form factor of this object model
    mdl_obj_form_factor ENUM(
        'rackunit',
        'module',
        'desktop',
        'portable'
    ),
    -- Height of object in vertical rack units (if rack-mountable)
    mdl_obj_units INTEGER,
    -- Depth of object in fractions (1/4) of total rack depth
    mdl_obj_depth INTEGER,
    --  Power consumption of this object
    mdl_obj_power INTEGER,
    -- 
    PRIMARY KEY (mdl_obj_id)
) /*$wgDBTableOptions*/;
-- 
-- Table of models of ports
DROP TABLE IF EXISTS /*$wgDBprefix*/dc_port_models;
CREATE TABLE /*$wgDBprefix*/dc_port_models (
    -- Unique ID of dc_port_models
    mdl_prt_id INTEGER AUTO_INCREMENT,
    -- Name of this port model
    mdl_prt_name VARBINARY(255) NOT NULL default '',
    -- Kind of this port model
    mdl_prt_kind VARBINARY(255) NOT NULL default '',
    -- Note about this port model
    mdl_prt_note BLOB,
    -- Category of this port model
    mdl_prt_category ENUM(
        'network',
        'power',
        'audio',
        'video',
        'sensor',
        'serial',
        'other'
    ) NOT NULL default 'other',
    -- Format of this port model
    mdl_prt_format ENUM(
        'digital',
        'analog',
        'mixed',
        'virtual',
        'none'
    ) NOT NULL default 'none',
    -- 
    PRIMARY KEY (mdl_prt_id)
) /*$wgDBTableOptions*/;
-- 
-- Meta Information
-- 
-- Table of tags used to categorize repairs
DROP TABLE IF EXISTS /*$wgDBprefix*/dc_meta_tags;
CREATE TABLE /*$wgDBprefix*/dc_meta_tags (
    -- Unique ID of dc_tags
    mta_tag_id INTEGER AUTO_INCREMENT,
    -- Name of this tag
    mta_tag_name VARBINARY(255) NOT NULL default '',
    -- 
    PRIMARY KEY (mta_tag_id)
) /*$wgDBTableOptions*/;
-- 
-- 
DROP TABLE IF EXISTS /*$wgDBprefix*/dc_meta_plans;
CREATE TABLE /*$wgDBprefix*/dc_meta_plans (
    -- Unique ID of dc_meta_plans
    mta_pln_id INTEGER AUTO_INCREMENT,
    -- Name of this plan
    mta_pln_name VARBINARY(255) NOT NULL default '',
    -- Tense of this link
    mta_pln_tense ENUM( 'past', 'present', 'future' ) default 'present',
    -- ID of space of this plan
    mta_pln_space INTEGER,
    -- Note for this plan
    mta_pln_note BLOB,
    -- 
    PRIMARY KEY (mta_pln_id)
) /*$wgDBTableOptions*/;
-- 
-- Table of changes made to targets (facilities, assets and models)
DROP TABLE IF EXISTS /*$wgDBprefix*/dc_meta_changes;
CREATE TABLE /*$wgDBprefix*/dc_meta_changes (
    -- Unique ID of dc_meta_changes
    mta_cng_id INTEGER AUTO_INCREMENT,
    -- ID of user who made change
    mta_cng_user INTEGER,
    -- Timestamp of when change was made
    mta_cng_timestamp BINARY(14),
    -- ID of component change was made to
    mta_cng_component_id INTEGER,
    -- Category of component type
    mta_cng_component_category ENUM(
        'facility',
        'asset',
        'model'
    ),
    -- Type of component change was made to
    mta_cng_component_type ENUM(
        'location',
        'space',
        'rack',
        'object',
        'port',
        'connection'
    ),
    -- Type of change that was made
    mta_cng_type VARBINARY(255),
    -- Text from user about change
    mta_cng_note TINYBLOB,
    -- Serialized php of row array after change
    mta_cng_state BLOB,
    -- 
    PRIMARY KEY (mta_cng_id)
) /*$wgDBTableOptions*/;
-- 
-- Table of models used by other models
DROP TABLE IF EXISTS /*$wgDBprefix*/dc_model_links;
CREATE TABLE /*$wgDBprefix*/dc_model_links (
    -- Unique ID of dc_meta_model_links
    lnk_mdl_id INTEGER AUTO_INCREMENT,
    -- Name of this link
    lnk_mdl_name VARBINARY(255) NOT NULL default '',
    -- Type of parent model using this link
    lnk_mdl_parent_type ENUM(
        'object'
    ),
    -- ID of parent model using this link
    lnk_mdl_parent_id INTEGER,
    -- Type of child model this link attaches
    lnk_mdl_child_type ENUM(
        'object',
        'port'
    ),
    -- ID of child model this link attaches
    lnk_mdl_child_id INTEGER,
    -- Quantity of attached models
    lnk_mdl_quantity INTEGER,
    -- 
    PRIMARY KEY (lnk_mdl_id)
) /*$wgDBTableOptions*/;
-- 
-- Table of assets used by other assets
DROP TABLE IF EXISTS /*$wgDBprefix*/dc_asset_links;
CREATE TABLE /*$wgDBprefix*/dc_asset_links (
    -- Unique ID of dc_meta_asset_links
    lnk_ast_id INTEGER AUTO_INCREMENT,
    -- Name of this asset
    lnk_ast_name VARBINARY(255) NOT NULL default '',
    -- ID of plan this link is a part of
    lnk_ast_plan INTEGER,
    -- Tense of this link
    lnk_ast_tense ENUM( 'past', 'present', 'future' ) default 'present',
    -- ID of parent asset link this link is a part of
    lnk_ast_parent_link INTEGER,
    -- Type of child asset this link attaches
    lnk_ast_asset_type ENUM(
        'rack',
        'object'
    ),
    -- ID of child asset this link attaches
    lnk_ast_asset_id INTEGER,
    -- X Position of child asset in parent asset
    lnk_ast_x INTEGER,
    -- Y Position of child asset in parent asset
    lnk_ast_y INTEGER,
    -- Z Position of child asset in parent asset
    lnk_ast_z INTEGER,
    -- Orientation of child asset in parent asset
    lnk_ast_orientation INTEGER,
    -- 
    PRIMARY KEY (lnk_ast_id)
) /*$wgDBTableOptions*/;
-- 
-- Table of meta fields to attach to components
DROP TABLE IF EXISTS /*$wgDBprefix*/dc_field_links;
CREATE TABLE /*$wgDBprefix*/dc_field_links (
    -- Unique ID of dc_meta_field_links
    lnk_fld_id INTEGER AUTO_INCREMENT,
    -- ID of field to attach
    lnk_fld_field INTEGER,
    -- Category of component type
    lnk_fld_component_category ENUM(
        'facility',
        'asset',
        'model'
    ),
    -- Type of component to attach field to
    lnk_fld_component_type ENUM(
        'location',
        'space',
        'rack',
        'object',
        'port',
        'connection'
    ),
    -- 
    PRIMARY KEY (lnk_fld_id)
) /*$wgDBTableOptions*/;
-- 
-- Table of meta fields to attach to models
DROP TABLE IF EXISTS /*$wgDBprefix*/dc_meta_fields;
CREATE TABLE /*$wgDBprefix*/dc_meta_fields (
    -- Unique ID of dc_meta_fields
    mta_fld_id INTEGER AUTO_INCREMENT,
    -- Name of this meta field
    mta_fld_name VARBINARY(255) NOT NULL default '',
    -- Format of this meta information
    mta_fld_format ENUM(
        'tag',
        'text',
        'string',
        'number',
        'boolean'
    ),
    -- 
    PRIMARY KEY (mta_fld_id)
) /*$wgDBTableOptions*/;
-- 
-- Table of meta information to attach to assets
DROP TABLE IF EXISTS /*$wgDBprefix*/dc_meta_values;
CREATE TABLE /*$wgDBprefix*/dc_meta_values (
    -- Unique ID of dc_meta_values
    mta_val_id INTEGER AUTO_INCREMENT,
    -- Category of component type
    mta_val_component_category ENUM(
        'facility',
        'asset',
        'model'
    ),
    -- Type of component to attach field to
    mta_val_component_type ENUM(
        'location',
        'space',
        'rack',
        'object',
        'port',
        'connection'
    ),
    -- ID of component this meta information is for
    mta_val_component_id INTEGER,
    -- ID of meta field this meta information represents
    mta_val_field INTEGER,
    -- Value of this meta information
    mta_val_value BLOB,
    -- 
    PRIMARY KEY (mta_val_id)
) /*$wgDBTableOptions*/;
-- 
-- Table of connections between ports
DROP TABLE IF EXISTS /*$wgDBprefix*/dc_meta_connections;
CREATE TABLE /*$wgDBprefix*/dc_meta_connections (
    -- Unique ID of dc_connections
    mta_con_id INTEGER AUTO_INCREMENT,
    -- ID of port being connected from
    mta_con_port_a INTEGER,
    -- ID of port being connected to
    mta_con_port_b INTEGER,
    -- 
    PRIMARY KEY (mta_con_id)
) /*$wgDBTableOptions*/;
