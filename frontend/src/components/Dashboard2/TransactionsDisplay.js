import React from "react";
import TransactionTableRow from "../Dashboard2/TransactionTableRow";

export default function TransactionsDisplay(props) {
  return (
    <>
      <table className="table table-hover">
        <tbody>
          {props.transactions && props.transactions.map(t =>
            <TransactionTableRow key={`transaction_${t.id}`}
                                 transaction={t}
                                 icons={props.icons}
                                 editCallback={props.editCallback}
                                 deleteCallback={props.deleteCallback} />
          )}
        </tbody>
      </table>
      </>
  )
}
