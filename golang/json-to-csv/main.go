package main

import (
	"encoding/json"
	"fmt"
	"io/ioutil"
	"log"
	"os"
	"strings"

	"github.com/docopt/docopt-go"
)

const usage = `Usage sample text.

Usage:
    $0 <json_file>
    $0 -h | --help

Options:
    -h --help  Show this help.
`

func main() {
	args, err := docopt.Parse(
		strings.Replace(usage, "$0", os.Args[0], -1),
		nil, true, "", false,
	)
	if err != nil {
		panic(err)
	}

	jsonEntries := getJsonEntries(args["<json_file>"].(string))

	csv := getCsvFromJsonEntries(jsonEntries)

	fmt.Print(csv)
}

func getJsonEntries(jsonFile string) []JsonEntry {
	jsonByteArray, err := ioutil.ReadFile(jsonFile)
	if err != nil {
		log.Fatal(err)
	}

	jsonEntries := []JsonEntry{}

	json.Unmarshal(jsonByteArray, &jsonEntries)

	return jsonEntries
}

func getCsvFromJsonEntries(jsonEntries []JsonEntry) string {
	csv := ""

	for _, entry := range jsonEntries {
		csv += fmt.Sprintf("%s\n", entry)
	}

	return csv
}
