import {DataTypes} from "./Types";

export function createDeepCopy(storeData, objectTypeToChange) {
  let objectToChange = storeData.modelData[objectTypeToChange];
  return JSON.parse(JSON.stringify(objectToChange));
}

export default class ApiResultConverter {
  static replaceIriByObjectInSubcategory(storeData, subcategories) {
    ApiResultConverter.#replaceIriByObjectInArray(storeData, subcategories, DataTypes.ICONS, "icon");
    return subcategories;
  }

  static replaceIriByObjectInTransactions(storeData, transactions) {
    ApiResultConverter.#replaceIriByObjectInArray(storeData, transactions, DataTypes.CURRENCIES, "currency")
    ApiResultConverter.#replaceIriByObjectInArray(storeData, transactions, DataTypes.SETTLEMENT_ACCOUNTS, "settlementAccount")
    ApiResultConverter.#replaceIriByObjectInArray(storeData, transactions, DataTypes.METHOD_OF_PAYMENTS, "methodOfPayment")
    ApiResultConverter.#replaceIriByObjectInArray(storeData, transactions, DataTypes.SUBCATEGORIES, "subcategory");
    ApiResultConverter.#replaceIriByObjectInArray(storeData, transactions, DataTypes.ICONS, "subcategory.icon");
    return transactions;
  }

  static replaceIriByObjectInTransaction(storeData, transaction) {
    ApiResultConverter.#replaceIriByObject(storeData, transaction, DataTypes.CURRENCIES, "currency")
    ApiResultConverter.#replaceIriByObject(storeData, transaction, DataTypes.SETTLEMENT_ACCOUNTS, "settlementAccount")
    ApiResultConverter.#replaceIriByObject(storeData, transaction, DataTypes.METHOD_OF_PAYMENTS, "methodOfPayment")
    ApiResultConverter.#replaceIriByObject(storeData, transaction, DataTypes.SUBCATEGORIES, "subcategory");
    return transaction;

  }

  static #replaceIriByObjectInArray(storeData, changingObject, objectTypeToRead, attributeToChange) {
    let objectToRead = storeData.modelData[objectTypeToRead];
    changingObject.forEach(c =>
      c[attributeToChange] =
        objectToRead.find(r => r['@id'] === c[attributeToChange])
        ?? c[attributeToChange]
    );
    return changingObject;
  }

  static #replaceIriByObject(storeData, changingObject, objectTypeToRead, attributeToChange) {
    let objectToRead = storeData.modelData[objectTypeToRead];
    changingObject[attributeToChange] = objectToRead.find(r =>
      r['@id'] === changingObject[attributeToChange])
      ?? changingObject[attributeToChange];
    return changingObject;
  }
}

export class ApiResultFilter {
  static filterTransactionsForSubcategory(storeData, subcategoryIri) {
    let transactions = ApiResultFilter.#createDeepCopy(storeData, DataTypes.TRANSACTIONS);
    return transactions.filter(t => t.subcategory === subcategoryIri);
  }

  static filterTransactionsForCategory(storeData, categoryIri) {
    let subcategoriesInCategory = ApiResultFilter.filterSubcategoriesForCategory(storeData, categoryIri);
    let subcategoriesIris = subcategoriesInCategory.map(s => s['@id']);
    let transactions = ApiResultFilter.#createDeepCopy(storeData, DataTypes.TRANSACTIONS);
    return transactions.filter(t => subcategoriesIris.includes(t.subcategory));
  }

  static findOneCategory(storeData, categoryIri) {
    let categories = storeData.modelData[DataTypes.CATEGORIES];
    let category = categories.find(c => c['@id'] === categoryIri);
    return ApiResultFilter.#deepCopy(category);
  }

  static findOneSettlementAccount(storeData, settlementAccountIri) {
    let settlementAccounts = storeData.modelData[DataTypes.SETTLEMENT_ACCOUNTS];
    let settlementAccount = settlementAccounts.find(c => c['@id'] === settlementAccountIri);
    return ApiResultFilter.#deepCopy(settlementAccount);
  }

  static findOneMethodOfPayment(storeData, methodOfPaymentIri) {
    let methodOfPayments = storeData.modelData[DataTypes.METHOD_OF_PAYMENTS];
    let methodOfPayment = methodOfPayments.find(c => c['@id'] === methodOfPaymentIri);
    return ApiResultFilter.#deepCopy(methodOfPayment);
  }

  static findOneSubcategory(storeData, subcategoryIri) {
    let subcategories = storeData.modelData[DataTypes.SUBCATEGORIES];
    let subcategory = subcategories.find(s => s['@id'] === subcategoryIri);
    return ApiResultFilter.#deepCopy(subcategory);
  }

  static findOneTransaction(storeData, transactionIri) {
    let transactions = storeData.modelData[DataTypes.TRANSACTIONS];
    let transaction = transactions.find(t => t['@id'] === transactionIri);
    return ApiResultFilter.#deepCopy(transaction);
  }

  static filterSubcategoriesForCategory(storeData, categoryIri) {
    let subcategories = ApiResultFilter.#createDeepCopy(storeData, DataTypes.SUBCATEGORIES);
    return subcategories.filter(t => t.category === categoryIri);
  }

  static #createDeepCopy(storeData, objectTypeToChange) {
    let objectToChange = storeData.modelData[objectTypeToChange];
    return ApiResultFilter.#deepCopy(objectToChange);
  }

  static #deepCopy(array) {
    return JSON.parse(JSON.stringify(array));
  }
}

export class UrlToIriConverter {
  static findIriForCategoryUrl(storeData, ownProps) {
    let categoryUrl = ownProps.match.params.category;
    let objectType = DataTypes.CATEGORIES;
    return UrlToIriConverter.#findIriForUrl(storeData, categoryUrl, objectType)
  }

  static findIriForSubcategoryUrl(storeData, ownProps) {
    let categoryUrl = ownProps.match.params.subcategory;
    let objectType = DataTypes.SUBCATEGORIES;
    return UrlToIriConverter.#findIriForUrl(storeData, categoryUrl, objectType)
  }

  static findIriForEditUrl(ownProps) {
    return "/" + ownProps.match.params.api
      + "/" + ownProps.match.params.datatype
      + "/" + ownProps.match.params.id;
  }

  static #findIriForUrl(storeData, url, objectType) {
    let iri = storeData.modelData[objectType].find(
      e => e.name.toLowerCase() === url);
    iri = iri ? iri['@id'] : null;
    return iri;
  }
}
