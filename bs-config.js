module.exports = {
    proxy: 'http://localhost:8000', // Assuming your Laravel app is running on port 8000
    files: ['resources/**/*', 'public/**/*'], // Watch these files for changes
    open: false, // Don't automatically open a new browser window
};
  