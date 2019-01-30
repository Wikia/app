export const bucketizeViewportHeight = (height) => {
  const buckets = [
    0, 400, 500, 600, 700, 800, 900, 1000
  ];
  let bucket = 1100;

  for (let i = 1; i < buckets.length; i++) {
    if (height >= buckets[i-1] && height < buckets[i]) {
      bucket = buckets[i];
    }
  }

  return bucket;
};
