/**
 * Objects types send to data store
 * @type {{SUBCATEGORIES: string, USERS: string, CATEGORIES: string, TRANSACTIONS: string}}
 */
export const DataTypes = {
  CATEGORIES: "categories",
  CATEGORY_BUDGETS: "category_budgets",
  CURRENCIES: "currencies",
  ICONS: "icons",
  METHOD_OF_PAYMENTS: "method_of_payments",
  SETTLEMENT_ACCOUNTS: "settlement_accounts",
  SUBCATEGORIES: "subcategories",
  SUBCATEGORY_BUDGETS: "subcategory_budgets",
  TAGS: "tags",
  TRANSACTIONS: "transactions",
  USERS: "users"
};

/**
 * Actions send to data store
 * @type {{DATA_LOAD: string}}
 */
export const ActionTypes = {
  DATA_LOAD: "data_load",
  GET_DATA: "get_data",
  STORE: "store",  // s.517; zapisuje
  UPDATE: "update",
  DELETE: "delete"
};
