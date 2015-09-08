package main

import (
	"fmt"
	"regexp"
)

type JsonEntry struct {
	Id                   int                   `json:"id"`
	ImageUrl             string                `json:"image_url"`
	Url                  string                `json:"url"`
	Articul              string                `json:"articul"`
	IsOfferVariant       int                   `json:"is_offer_variant"`
	Type                 string                `json:"type"`
	Name                 string                `json:"name"`
	Comment              string                `json:"comment"`
	Price                string                `json:"price"`
	PriceWithoutDiscount string                `json:"price_without_discount"`
	Weight               string                `json:"weight"`
	Comments             []JsonEntryComment    `json:"comments"`
	Collections          []JsonEntryCollection `json:"collections"`
	Features             []JsonEntryFeature    `json:"features"`
	Properties           []JsonEntryProperty   `json:"properties"`
}

type JsonEntryComment struct {
	Type    string `json:"type"`
	Comment string `json:"comment"`
}

type JsonEntryCollection struct {
	Id   string `json:"id"`
	Name string `json:"name"`
	Url  string `json:"url"`
}

type JsonEntryFeature struct {
	Type  string `json:"type"`
	Value string `json:"value"`
}

type JsonEntryProperty struct {
	Type  string `json:"type"`
	Value string `json:"value"`
}

var priceRegexp = regexp.MustCompile("([^\\d])")

func (entry JsonEntry) String() string {
	return entry.Articul + "," +
		entry.ImageUrl + "," +
		entry.GetPrice() + "," +
		entry.GetCategoriesAsString() + "," +
		"," +
		entry.Comment + "," +
		entry.GetMetal() + "," +
		entry.GetInsertion() + "," +
		entry.GetSize()
}

func (entry JsonEntry) GetPrice() string {
	return string(priceRegexp.ReplaceAllString(entry.Price, ""))
}

func (entry JsonEntry) GetCategoriesAsString() string {
	result := ""
	for _, collection := range entry.Collections {
		result += collection.Name + ","
	}
	return fmt.Sprintf("\"%s\"", result)
}

func (entry JsonEntry) GetFeature(featureType string) string {
	for _, feature := range entry.Features {
		if feature.Type == featureType {
			return feature.Value
		}
	}

	return ""
}

func (entry JsonEntry) GetMetal() string {
	return entry.GetFeature("Металл")
}

func (entry JsonEntry) GetInsertion() string {
	return entry.GetFeature("Вставка")
}

func (entry JsonEntry) GetSize() string {
	return ""
}
