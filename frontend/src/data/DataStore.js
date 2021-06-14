import { applyMiddleware, combineReducers, compose, createStore } from 'redux';
import { Reducer } from "./Reducer";
import { createRestMiddleware } from "../webservices/RestMiddleware";

const restMiddleware = createRestMiddleware(
  "http://localhost:8000/api/categories",
  "http://localhost:8000/api/category_budgets",
  "http://localhost:8000/api/currencies",
  "http://localhost:8000/api/icons",
  "http://localhost:8000/api/method_of_payments",
  "http://localhost:8000/api/settlement_accounts",
  "http://localhost:8000/api/subcategories",
  "http://localhost:8000/api/subcategory_budgets",
  "http://localhost:8000/api/tags",
  "http://localhost:8000/api/transactions",
  "http://localhost:8000/api/users",
);

/**
 * Store new Data Store returned from createStore, which use middleware to correct process Promise
 *
 * Using middleware causes that actions will be passed to middleware and result will be passed as
 * an argument of function createStore (which creates data store)
 *
 * 1arg - object in which properties name is the same as DataStore sections and them values are
 * reducers used to manage this data
 */
export const CountiveDataStore =
  createStore(combineReducers({
      modelData: Reducer
    }),
    compose(
      applyMiddleware(restMiddleware)
    )
  );

export { getData, deleteData, saveData } from "./ActionCreators";
