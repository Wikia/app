#!/usr/bin/env node

const axios = require('axios');
const chalk = require('chalk');
const fs = require('fs');
const readline = require('readline');
const vendotListPath = './src/vendorlist.json';
const currentVendorList = require(vendotListPath);
const rl = readline.createInterface({
	input: process.stdin,
	output: process.stdout
});

console.log(chalk.yellow(`Current vendor list version: ${currentVendorList.vendorListVersion}, last updated ${currentVendorList.lastUpdated}`));
axios.get('https://vendorlist.consensu.org/vendorlist.json')
	.then(({data}) => {
		console.log(chalk.green(`New vendor list version: ${data.vendorListVersion}, last updated ${data.lastUpdated}\n`));
		console.log(`-----------------------------------------\nID\tVendor Name\n-----------------------------------------`);
		data.vendors.forEach(({id, name}) => {
			console.log(`${id}\t${name}`);
		});

		console.log(chalk.yellow('\nSaving...'));
		fs.writeFileSync(vendotListPath, JSON.stringify(data, null, '\t'));
		console.log(chalk.green('OK'));
		process.exit(0);
	})
	.catch((error) => {
		console.error(chalk.red(`Error while processing vendor lists: ${error}`));
		process.exit(1);
	});
