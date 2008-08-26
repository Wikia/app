/* delay calculation for linux systems */
#include <sys/time.h>
#include <stdio.h>

int delay()
{
    /* Always serve at idle cpu */
    if (check_idle() > 5 )
	return (0);

    /* 10.0 load is too high */
    if (check_load() > 1000)
	return (3000);

    /* at 2.0 load respond immediately */
    if (check_load() < 200)
	return (0);

    /* Add load-dependant delay */
    return(check_load()/100);
}

int check_load()
{
    FILE *fd;
    char loadline[128];
    float load;
    time_t currenttime;
    static time_t lastchecked;
    static float lastload;

    time(&currenttime);
    if ((currenttime - lastchecked) < 1)
	return (lastload * 100);

    fd = fopen("/proc/loadavg", "r");
    fscanf(fd, "%f ", &load);
    fclose(fd);
    lastload = load;
    time(&lastchecked);
    return (load * 100);
}

int check_idle()
{
    FILE *fd;
    char statline[128], cputext[6];
    unsigned long long user, nice, sys, idle, total;
    static unsigned long long ouser, onice, osys, oidle;
    static time_t lastchecked = 0;
    static int lastidle = 50;
    time_t currenttime;
    int idleproc;

    time(&currenttime);
    if ((currenttime - lastchecked) < 1) {
	return (lastidle);
    }

    fd = fopen("/proc/stat", "r");
    fscanf(fd, "%s %llu %llu %llu %llu", cputext, &user, &nice, &sys,
	   &idle);
    total =
	((user - ouser) + (nice - onice) + (sys - osys) + (idle - oidle));
    if (total > 0) {
	idleproc = ((idle - oidle) * 100) / total;
    } else {
	idleproc = 100;
    }
    lastidle = idleproc;

    oidle = idle;
    ouser = user;
    osys = sys;
    onice = nice;
    fclose(fd);
    time(&lastchecked);

    return (idleproc);
}
