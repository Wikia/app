/**
 * Configuration file for libwsparse.
 */

#ifndef _WS_CONFIG_H
#define _WS_CONFIG_H

/**
 * By default, the parser keeps several orphan nodes in the list of nodes, because
 * moving them would take extra time that from opinion of the developer writing this
 * lines is not worth it. If you care, you may actually define it.
 */
#undef WS_USE_COMPLETE_OPTIMIZATION

#define WS_TREE_SIZE_INIT 256
#define WS_TREE_SIZE_STEP 256

#define WS_STACK_SIZE_INIT 50
#define WS_STACK_SIZE_STEP 20

#endif /* _WS_CONFIG_H */
