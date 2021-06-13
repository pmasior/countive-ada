import React from "react";

export default function TransactionTableRow(props) {
  let t = props.transaction;
  const findIcon = (subcategory) => {
    let icon = props.icons.find(i => i['@id'] === subcategory.icon)
    return icon ? icon.name : ""
  }

  return (
    <tr>
      <td>
        <i className={`${findIcon(t.subcategory)} card-img-top h5 m-0`}
           style={{'color': t.subcategory.color}} />
      </td>
      <td>{t.settlementAccount ? t.settlementAccount.name : null}</td>
      <td>{t.methodOfPayment ? t.methodOfPayment.name : null}</td>
      <td>{t.note}</td>
      <td>
        {t.amount.replace(/\.?0+$/, '')}
        {" "}
        {t.currency ? t.currency.shortName : null}
      </td>
      <td>
        <button className="btn btn-sm btn-warning"
                data-bs-toggle="modal"
                data-bs-target="#exampleModal"
                onClick={() => props.editCallback(t)}>
          Edit
        </button>
      </td>
    </tr>
  )
}
