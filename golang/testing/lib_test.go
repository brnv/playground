package adder

import (
	"reflect"
	"testing"
)

func TestSum(t *testing.T) {
	tests := []struct {
		a   int
		b   int
		sum int
	}{
		{1, 1, 2},
		{10, 4, 14},
		{22, 40, 62},
		{-15, -10, -25},
		{-24, 50, 26},
	}

	for _, test := range tests {
		actual := Add(test.a, test.b)

		if !reflect.DeepEqual(test.sum, actual) {
			t.Errorf("%v + %v is supposed to be %v, not %v",
				test.a,
				test.b,
				test.sum,
				actual)
		}
	}
}
