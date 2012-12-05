Yass
================================================================================

Yet Another Session Saver for MODX Revolution

Features:
--------------------------------------------------------------------------------
Yass is a simple session saving solution for MODX Revolution. With this snippet 
you could display a link (a form post ist possible too) that changes a value in 
the current user session. The key name, value and expiration could be set by 
snippet parameter. 

Installation:
--------------------------------------------------------------------------------
MODX Package Management

Usage
--------------------------------------------------------------------------------

[[!Yass]]

with the following properties:

Property      | Description                                   | Default
------------- | --------------------------------------------- | -----------------------------------------
resource      | Resource Id                                   | Current Resource id	
keyName       | Session Key Name                              | default
keyValue      | Session Key Value                             | defaultValue
keyExpires    | Session Key Expires (in seconds)              | 0 (does not expire)
language      | Snippet Language                              | en
toPlaceholder | Surpresses output and sets placeholder        | false
debug         | Show Debug Information                        | false
enabledTpl    | Chunk that is shown if session key is set     | see defaultEnabled.template.html in core/components/yass/templates
disabledTpl   | Chunk that is shown if session key is not set | see defaultDisabled.template.html in core/components/yass/templates

The following placeholder could be used in the template chunks:

Placeholder | Value
----------- | ------------------------------------------------------------------
lang.*      | Language settings
id          | Set by resource parameter
enableUrl   | Will be generated from id, keyName and keyValue
disableUrl  | Will be generated from id and keyName
key         | Set by keyName parameter
value       | Set by keyValue parameter

The following placeholder are set with the toPlaceholder parameter:

Placeholder           | Value
--------------------- | --------------------------------------------------------
yass.(keyname).value  | Current value of the keyname
yass.(keyname).output | 
yass.(keyname).debug  | 

(keyname) is set by keyName parameter - if keyName is not set the placeholder 
names are yass.value, yass.output, yass.debug
