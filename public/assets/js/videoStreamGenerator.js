// videoStreamGenerator.js

const generateVideoStream = (callback) => {
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    const videoWidth = 640;
    const videoHeight = 480;
  
    canvas.width = videoWidth;
    canvas.height = videoHeight;
  
    const drawFrame = () => {
      // Simulate a video frame (you'd replace this with actual video capture logic)
      ctx.fillStyle = 'black';
      ctx.fillRect(0, 0, videoWidth, videoHeight);
      ctx.fillStyle = 'white';
      ctx.fillText('Video Frame ' + new Date().toLocaleTimeString(), 10, 30);
  
      // Convert the canvas content to a Blob
      canvas.toBlob((blob) => {
        // Invoke the callback with the generated stream data
        callback(blob);
      }, 'video/webm');
    };
  
    // Simulate generating a new frame every 100 milliseconds
    setInterval(drawFrame, 100);
  };
  
  // Example usage:
  generateVideoStream((streamData) => {
    // Log or send the streamData to your server for broadcasting
    console.log('Generated Video Stream Data:', streamData);
  });
  