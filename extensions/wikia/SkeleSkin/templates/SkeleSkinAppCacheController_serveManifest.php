CACHE MANIFEST
#Skin: skeleskin
#cb<?= $cacheVersion ;?>


#Keep the following resources in cache
<?= $cacheFiles ;?>


# Anything else requires direct connection to the server
NETWORK:
<?= $freshFiles ;?>
