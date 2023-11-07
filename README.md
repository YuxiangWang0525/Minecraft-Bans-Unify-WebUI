# Minecraft-Bans-Unify-WebUI
A Minecraft Bans WebUI for many bans plugin. just like LiteBans WebUI
## Why This
Currently, only LiteBans supports comprehensive WebUI public display on Minecraft server plugins, while other plugins do not have WebUI. This program is a WebUI system that is compatible with multiple plugins  
## How to configuration
You only need to modify config.json  
``` Json
# config.json

{
    "Plugin":"Your_Plugin_Name_Here(Support AdvancedBan&BansPlus)", # Fill in the supported plugins name according to the table below
    "database_host":"Your Database Server IP Address",
    "database_name":"Your Database Name",
    "database_user":"Your Database Username",
    "database_password":"Your Database Password"
}
```
## Supported plugins
- [x] AdvancedBan
- [x] BansPlus (Bans+) Just fill "BansPlus"
- [ ] MaxBans
- [ ] BanManager

 **Never:LiteBans**   Because Litebans already has a complete WebUI and is commercial software, we are unable to support it
