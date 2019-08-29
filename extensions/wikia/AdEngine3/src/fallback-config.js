export const fallbackInstantConfig = {
  "icConfiant": [{"apps": ["oasis"], "value": true}],
  "icBabDetection": [{"apps": ["f2", "gamepedia", "mobile-wiki", "oasis"], "regions": ["XX"], "value": true}],
  "wgAdDriverBillTheLizardConfig": {
    "timeout": 2000,
    "projects": {
      "vcr": [{
        "name": "vcr",
        "countries": ["PL/100", "CZ/100", "HK/100", "UK/100", "GB/100"],
        "dfp_targeting": true
      }],
      "cheshirecat": [{
        "name": "cheshirecat",
        "on_1": ["catlapseIncontentBoxad"],
        "countries": ["PL/100", "UK/100", "GB/100", "DK/100", "FR/100", "IT/100", "NI/100"],
        "dfp_targeting": true
      }],
      "queen_of_hearts": [{
        "name": "ctp_desktop:2.0.0",
        "on_0": ["disableAutoPlay"],
        "on_1": ["disableAutoPlay"],
        "countries": ["XX/0.05-cached"]
      }]
    }
  },
  "icBTRec": [{"apps": ["oasis"], "regions": ["XX"], "value": true}],
  "wgAdDriverUnstickHiViLeaderboardTimeout": 475,
  "icPorvataDirect": [{"apps": ["f2", "gamepedia", "mobile-wiki", "oasis"], "value": false}],
  "wgAdDriverUnstickHiViLeaderboardAfterTimeoutCountries": ["PL/100"],
  "icHiViLeaderboardUnstickTimeout": [{"apps": ["oasis"], "regions": ["PL"], "sampling": 100.0, "value": 475}]
};
