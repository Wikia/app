<?php

namespace Mcustiel\PowerRoute\Common;

class ConfigOptions
{
    const CONFIG_ROOT_NODE = 'start';
    const CONFIG_NODES = 'nodes';
    const CONFIG_NODE_CONDITION = 'condition';
    const CONFIG_NODE_CONDITION_ALL = 'all-of';
    const CONFIG_NODE_CONDITION_ONE = 'one-of';
    const CONFIG_NODE_CONDITION_SOURCE = 'input-source';
    const CONFIG_NODE_CONDITION_MATCHER = 'matcher';
    const CONFIG_NODE_ACTIONS = 'actions';
    const CONFIG_NODE_ACTIONS_MATCH = 'if-matches';
    const CONFIG_NODE_ACTIONS_NOTMATCH = 'else';
}
