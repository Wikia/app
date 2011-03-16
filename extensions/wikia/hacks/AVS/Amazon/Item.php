<?php
class Amazon_Item
{
    public function getFormattedPrice()
    {
        $price = null;

        if (isset($this->ItemAttributes->ListPrice)) {
            $price = $this->ItemAttributes->ListPrice->FormattedPrice;
        }

        if (isset($this->OfferSummary->LowestCollectiblePrice)) {
            $price = $this->OfferSummary->LowestCollectiblePrice->FormattedPrice;
        }

        return $price;
    }

    public function getLowestPriceFormatted()
    {
        return $this->getFormattedPrice();
    }

    public function getLowestPriceAmount()
    {
        $amount = null;

        if (isset($this->ItemAttributes->ListPrice)) {
            $amount = $this->ItemAttributes->ListPrice->Amount;
        }

        if (isset($this->OfferSummary->LowestCollectiblePrice)) {
            $amount = $this->OfferSummary->LowestCollectiblePrice->Amount;
        }

        return $amount;
    }

    public function getLowestPriceCurrencyCode()
    {
        $currency = null;

        if (isset($this->ItemAttributes->ListPrice)) {
            $currency = $this->ItemAttributes->ListPrice->CurrencyCode;
        }

        if (isset($this->OfferSummary->LowestCollectiblePrice)) {
            $currency = $this->OfferSummary->LowestCollectiblePrice->CurrencyCode;
        }

        return $currency;
    }
}
