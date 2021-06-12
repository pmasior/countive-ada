import { ActionTypes } from "../data/Types";
import { RestDataSource } from "./RestDataSource";
import { DataTypes } from "../data/Types";

export const createRestMiddleware = (categoriesURL,
                                     categoryBudgetsURL,
                                     currenciesURL,
                                     iconsURL,
                                     methodOfPaymentsURL,
                                     settlementAccountsURL,
                                     subcategoriesURL,
                                     subcategoryBudgetsURL,
                                     tagsURL,
                                     transactionsURL,
                                     usersURL) => {
  const dataSources = {
    [DataTypes.CATEGORIES]: new RestDataSource(categoriesURL, () => { }),
    [DataTypes.CATEGORY_BUDGETS]: new RestDataSource(categoryBudgetsURL, () => { }),
    [DataTypes.CURRENCIES]: new RestDataSource(currenciesURL, () => { }),
    [DataTypes.ICONS]: new RestDataSource(iconsURL, () => { }),
    [DataTypes.METHOD_OF_PAYMENTS]: new RestDataSource(methodOfPaymentsURL, () => { }),
    [DataTypes.SETTLEMENT_ACCOUNTS]: new RestDataSource(settlementAccountsURL, () => { }),
    [DataTypes.SUBCATEGORIES]: new RestDataSource(subcategoriesURL, () => { }),
    [DataTypes.SUBCATEGORY_BUDGETS]: new RestDataSource(subcategoryBudgetsURL, () => { }),
    [DataTypes.TAGS]: new RestDataSource(tagsURL, () => { }),
    [DataTypes.TRANSACTIONS]: new RestDataSource(transactionsURL, () => { }),
    [DataTypes.USERS]: new RestDataSource(usersURL, () => { }),
  }

  return ({dispatch, getState}) =>
    (next) =>
      (action) => {
        switch (action.type) {
          case ActionTypes.GET_DATA:
            if (getState().modelData[action.dataType].length === 0) {
              dataSources[action.dataType].getData((data) =>
                data["hydra:member"].forEach(item =>
                  next({
                    type: ActionTypes.STORE,
                    dataType: action.dataType,
                    payload: item
                  })
                )
              );
            }
            break;
          case ActionTypes.STORE:
            // action.payload['@id'] = null;  // TODO: delete?
            dataSources[action.dataType].store(action.payload, data =>
              next({...action, payload: data }));
            break;
          case ActionTypes.UPDATE:
            dataSources[action.dataType].update(action.payload, data =>
              next({...action, payload: data }));
            break;
          case ActionTypes.DELETE:
            dataSources[action.dataType].delete(action.payload, () =>
              next({...action}));
            break;
          default:
            next(action);
        }
      }
}
