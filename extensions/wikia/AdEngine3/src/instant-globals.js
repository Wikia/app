export default {
  get: (key, defaultValue = null) => {
    if (!window.Wikia.InstantGlobals) {
      return defaultValue;
    }

    return window.Wikia.InstantGlobals[key] || defaultValue;
  }
}
