// format time

export const formatTime = function (time) {
    return [
        Math.floor((time % 3600) / 60), // minutes
        ("00" + Math.floor(time % 60)).slice(-2), // seconds
    ].join(":");
};
export const formatSize = function (x) {
    const units = ["bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];
    let l = 0,
        n = parseInt(x, 10) || 0;

    while (n >= 1024 && ++l) {
        n = n / 1024;
    }

    return n.toFixed(n < 10 && l > 0 ? 1 : 0) + " " + units[l];
};
