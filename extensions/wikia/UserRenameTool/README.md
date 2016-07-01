## TODO:
- [x] remove unused files
- [x] remove unused methods
- [x] remove redundant PHPDocs
- [x] unify file names
- [x] simplify controller
- [x] simplify log methods
- [x] replace old message methods with wfMessage
- [x] combine helper and log formatter files
- [ ] simplify process file
- [ ] simplify task file
- [ ] add missing log methods
- [ ] add reverse option to each rename process step
- [ ] use user services if possible
- [ ] revert all changes when error occurs

## Current problems
- when process fails in the middle, user with new username is not removed,
so you cannot retry process with the same username.
- messages are not consistent i.e. you can get message about failure and info that
process is going on
- querying takes a lot of time without any notification
(fill form, press submit button, you have to wait >30 sec)
