<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>{$title}</title>
    <link rel="stylesheet" type="text/css" href="{$subdir}media/style.css" />
    <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'/>
  </head>
  <body>
  
    <h1>{$maintitle}{if $title != $maintitle} :: {$title}{/if}</h1>

    <table width="100%">
      <tr valign="top">
        <td class="menu">
          {if count($ric) >= 1}
            <div class="package">
              <div id="ric">
                {section name=ric loop=$ric}
                  <p><a href="{$subdir}{$ric[ric].file}">{$ric[ric].name}</a></p>
                {/section}
              </div>
            </div>
          {/if}
          {if $hastodos}
            <div class="package">
              <div id="todolist">
                <p><a href="{$subdir}{$todolink}">Todo List</a></p>
              </div>
            </div>
          {/if}
          <h2>Packages:</h2>
          <div class="package">
            <ul>
              {section name=packagelist loop=$packageindex}
                <li>
                  <a href="{$subdir}{$packageindex[packagelist].link}">{$packageindex[packagelist].title}</a>
                </li>
              {/section}
            </ul>
          </div>
          {if $tutorials}
            <h2>Tutorials/Manuals:</h2>
            <div class="package">
              {if $tutorials.pkg}
                <strong>Package-level:</strong>
                {section name=ext loop=$tutorials.pkg}
                  {$tutorials.pkg[ext]}
                {/section}
              {/if}
              {if $tutorials.cls}
                <strong>Class-level:</strong>
                {section name=ext loop=$tutorials.cls}
                  {$tutorials.cls[ext]}
                {/section}
              {/if}
              {if $tutorials.proc}
                <strong>Procedural-level:</strong>
                {section name=ext loop=$tutorials.proc}
                  {$tutorials.proc[ext]}
                {/section}
              {/if}
            </div>
          {/if}
          {if !$noleftindex}{assign var="noleftindex" value=false}{/if}
          {if !$noleftindex}
            {if $compiledinterfaceindex}
              <h2>Interfaces:</h2>
              {eval var=$compiledinterfaceindex}
            {/if}
            {if $compiledclassindex}
              <h2>Classes:</h2>
              {eval var=$compiledclassindex}
            {/if}
          {/if}
        </td>
        <td>
          <table style="width:750px;" cellpadding="10" cellspacing="10px">
            <tr>
              <td valign="top">
                {if !$hasel}{assign var="hasel" value=false}{/if}
                {if $eltype == 'class' && $is_interface}
                  {assign var="eltype" value="interface"}
                {/if}
                {if $hasel}
                  <h2>{$package}{if $subpackage != ''}::{$subpackage}{/if}::{$class_name}</h2>
                {/if}
                <div class="menu">
          {assign var="packagehaselements" value=false}
          {foreach from=$packageindex item=thispackage}
            {if in_array($package, $thispackage)}
              {assign var="packagehaselements" value=true}
            {/if}
          {/foreach}
          [ <a href="{$subdir}index.html">Index</a> ]
          {if $packagehaselements}
            [ <a href="{$subdir}classtrees_{$package}.html">{$package} classes</a> ]
            [ <a href="{$subdir}elementindex_{$package}.html">{$package} elements</a> ]
          {/if}
          [ <a href="{$subdir}elementindex.html">All elements</a> ]
          [ <a href="{$subdir}errors.html">Errors</a> ]
                </div>