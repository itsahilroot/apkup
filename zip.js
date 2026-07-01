const fs = require('fs');
const path = require('path');
const { ZipArchive } = require('archiver');

// The output zip file name
const zipName = 'apkup.zip';
const output = fs.createWriteStream(path.join(__dirname, zipName));

const archive = new ZipArchive({
  zlib: { level: 9 } // Maximum compression
});

output.on('close', function() {
  console.log(`\n🎉 Success! Theme zipped successfully into: ${zipName}`);
  console.log(`📦 Size: ${(archive.pointer() / 1024 / 1024).toFixed(2)} MB`);
});

archive.on('warning', function(err) {
  if (err.code === 'ENOENT') {
    console.warn('⚠️ Warning:', err);
  } else {
    throw err;
  }
});

archive.on('error', function(err) {
  throw err;
});

archive.pipe(output);

// Glob pattern to include everything except specified ignores
archive.glob('**/*', {
  cwd: __dirname,
  ignore: [
    'node_modules',
    'node_modules/**',
    '.git',
    '.git/**',
    '.gitignore',
    'package-lock.json',
    zipName,
    'zip.js',
    '.postcss.config.js',
    'tailwind.config.js',
    'vite.config.js'
  ]
}, {
  prefix: 'apkup'
});

archive.finalize();
