-- Packages table
CREATE TABLE /*_*/packageforce_packages (
	-- ID
	pk_id int not null primary key auto_increment,

	pk_name varbinary(64) not null
) /*$wgDBTableOptions*/;

-- Package members
CREATE TABLE /*_*/packageforce_package_members (
	-- ID
	pm_id int not null primary key auto_increment,

	-- packageforce_packages.pk_id
	pm_package int not null,

	-- page.page_id
	pm_page int not null
) /*$wgDBTableOptions*/;
