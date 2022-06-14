tsParticles.load("tsparticles", {
  fpsLimit: 60,
  particles: {
    color: {
      value: ["#E3F8FF", "#28CC9E", "#A6ED8E"]
    },
    move: {
      enable: true,
      direction: "top-right",
      random: true,
      speed: 1.5
    },
    number: {
      value: 50
    },
    opacity: {
      value: 0.6,
      random: {
        enable: true,
        minimumValue: 0.3
      }
    },
    shape: {
      type: ["square", "circle"]
    },
    size: {
      value: 2
    }
  }
});