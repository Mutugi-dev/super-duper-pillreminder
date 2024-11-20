<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Styled Button</title>
  <style>
    /* Button styling from Uiverse.io by Spacious74 */
    
    .button {
      cursor: pointer;
      font-size: 1.4rem;
      border-radius: 16px;
      border: none;
      padding: 2px;
      background: radial-gradient(circle 80px at 80% -10%, #ffffff, #181b1b);
      position: relative;
      overflow: hidden;
    }

    .button::after {
      content: "";
      position: absolute;
      width: 65%;
      height: 60%;
      border-radius: 120px;
      top: 0;
      right: 0;
      box-shadow: 0 0 20px #ffffff38;
      z-index: -1;
    }

    .blob1 {
      position: absolute;
      width: 70px;
      height: 100%;
      border-radius: 16px;
      bottom: 0;
      left: 0;
      background: radial-gradient(circle 60px at 0% 100%, #3fe9ff, #0000ff80, transparent);
      box-shadow: -10px 10px 30px #0051ff2d;
    }

    .blob2 {
      position: absolute;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      top: -20px;
      right: -20px;
      background: radial-gradient(circle 40px at 50% 50%, #ff3f8a, #ff0000, transparent);
      box-shadow: 10px -10px 30px #ff00502d;
    }

    .inner {
      padding: 14px 25px;
      border-radius: 14px;
      color: #fff;
      z-index: 3;
      position: relative;
      background: radial-gradient(circle 80px at 80% -50%, #777777, #0f1111);
    }

    .inner::before {
      content: "";
      width: 100%;
      height: 100%;
      left: 0;
      top: 0;
      border-radius: 14px;
      background: radial-gradient(circle 60px at 0% 100%, #00e1ff1a, #0000ff11, transparent);
      position: absolute;
      z-index: -1;
    }
  </style>
</head>
<body>

<button class="button">
  <div class="blob1"></div>
  <div class="blob2"></div>
  <div class="inner">Realism</div>
</button>

</body>
</html>
