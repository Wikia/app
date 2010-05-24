delete from page where page_id in (select cl_from from categorylinks where cl_to='Draft');
delete from text where old_id in (select rev_text_id from revision, categorylinks where revision.rev_page=categorylinks.cl_from and cl_to='Draft');
delete from revision where rev_page in (select cl_from from categorylinks where cl_to='Draft');

delete from categorylinks where cl_to='Draft';
delete from pagelinks where pl_namespace=14 and pl_title='Draft';

delete from revision where rev_id not in (select page_latest from page);
delete from text where old_id not in (select rev_text_id from revision);
update revision set rev_comment='', rev_user=0, rev_user_text='Default', rev_timestamp = date_format(now(), "%Y%m%d%H%i%S");
