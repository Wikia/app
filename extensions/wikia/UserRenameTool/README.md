## User Rename Tool

User references in MediaWiki are done with a mix of user ID and user name
depending on the situation.  Because of this, changing a username can be
tricky and time consuming as every instance of the username across multiple
clusters and multiple databases must be updated.

### Documentation

- [How to initiate a user rename](https://wikia-inc.atlassian.net/wiki/display/SUS/User+Rename+Process+-+User+Interaction)
- [Rename process architecture](https://wikia-inc.atlassian.net/wiki/display/SUS/User+Rename+Process+-+Automated+flow)
- [Global Flags used](https://wikia-inc.atlassian.net/wiki/display/SUS/User+Rename+Flags)

### Analytics

- [Kibana Board for DEV request](https://kibana.wikia-inc.com/index.html#/dashboard/elasticsearch/UserRename%20Tool) : Note that this does not show logging from the wfShellExec script since that output is sent to STDOUT.


### TODO:
- [x] remove unused files
- [x] remove unused methods
- [x] remove redundant PHPDocs
- [x] unify file names
- [x] simplify controller
- [x] simplify log methods
- [x] replace old message methods with wfMessage
- [x] combine helper and log formatter files
- [ ] allow normal users to initiate the process
- [x] simplify process file
- [x] simplify task file
- [x] add missing log methods
- [ ] add reverse option to each rename process step
- [ ] use user services if possible
- [ ] revert all changes when error occurs

### Current problems
- Links to tasks by ID have wrong host in dev (local.XXX.wikia-dev.com rather than commmunity.XXX.wikia-dev.com)
- StaffLog currently reports problems but process seems to complete
