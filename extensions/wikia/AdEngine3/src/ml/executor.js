let featuredVideoAutoPlayDisabled = false;

export const methods = {
  disableAutoPlay: () => featuredVideoAutoPlayDisabled = true
};

export const isAutoPlayDisabled = () => featuredVideoAutoPlayDisabled;
