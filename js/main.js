const mysql = require('mysql2/promise');

async function main() {
  const connection = await mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'my22'
  });

  // Truncate the table before inserting new data
  await connection.execute('TRUNCATE TABLE js_functions');

  // Get a list of JavaScript functions
  const functions = Object.getOwnPropertyNames(global).filter(name => typeof global[name] === 'function');

  // Sort the functions array by name in alphabetical order
  functions.sort();

  for (const funcName of functions) {
    const func = global[funcName];
    const params = func.toString().match(/\(([^)]*)\)/)[1].split(',').map(param => param.trim());
    const returnType = 'unknown'; // JavaScript does not have a built-in way to determine the return type of a function

    // Insert the function into the database
    await connection.execute('INSERT INTO js_functions (name, params, return_type) VALUES (?, ?, ?)', [funcName, params.join(', '), returnType]);
  }

  await connection.end();
}

main();